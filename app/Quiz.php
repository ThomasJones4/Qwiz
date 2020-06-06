<?php

namespace App;

use App\Question;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

    protected $fillable = ['user_id', 'invite_code', 'name'];

    public function questions() {
      return $this->hasMany(Question::class);
    }

    public function quiz_master() {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function users() {
      return $this->belongsToMany(User::class);
    }

    public function correct_so_far() {
      $count = 0;
      $this->questions->each(function ($question) use ($count) {
          if ($question->correct()) {
            $count++;
          }
      });
      return $count;
    }

    public function is_live() {
      return (null == $this->invite_code && !$this->is_finish());
    }

    public function is_finish() {
      return ($this->questions()->where('released', "0")->get()->count() == 0 && $this->invite_code == null);
    }

    public function latest_unreleased() {
       return $this->questions()->get()->where('released', "0")->sortBy('order')->first();
    }

    public function get_participant_mark(User $user) {
      $mark = 0;

      //get only the users last response to each question
      $this->questions()->each(function ($question) use ($user, &$mark) {
         if (null != $question->responses->where('user_id', $user->id)->sortBy('created_at')->last() && $question->responses->where('user_id', $user->id)->sortBy('created_at')->last()->correct) {
           $mark++;
         }
       });
       return $mark;
    }

    public function ranked_users() {

      $quiz = $this;
      $su = [];
      $su = $this->users->each(function($user) use ($quiz, &$su) {
            $user['total'] = $quiz->get_participant_mark($user);
        });
      $su = $su->sortByDesc('total');


      $first_place_threshold = (null != $su->first())? $su->first()->total : -1;

      $second_place_threshold = $su->where('total', '<', $first_place_threshold)->first();
      $second_place_threshold = (null != $second_place_threshold)? $second_place_threshold->total : $first_place_threshold;

      $third_place_threshold = $su->where('total', '<', $second_place_threshold)->first();
      $third_place_threshold = (null != $third_place_threshold)? $third_place_threshold->total : $second_place_threshold;

      $penultimate_place_threshold = $su->where('total', '<', 'third_place_threshold')->sortBy('total')->first();
      $penultimate_place_threshold = (null != $penultimate_place_threshold)? $penultimate_place_threshold->total : 1;

      $ranked_counter = 0;
      $su->each(function (&$user) use ($first_place_threshold, $second_place_threshold, $third_place_threshold, $penultimate_place_threshold, $ranked_counter) {
        switch ($user->total) {
          case $first_place_threshold:
            $user['rank'] = 1;
            $ranked_counter = 1;
            break;
          case $second_place_threshold:
            $user['rank'] = 2;
            $ranked_counter = 2;
            break;
          case $third_place_threshold:
            $user['rank'] = 3;
            $ranked_counter = 3;
            break;
          case $penultimate_place_threshold:
            $user['rank'] = -2;
            $ranked_counter++;
            break;
          default:
            $user['rank'] = $ranked_counter;
            $ranked_counter++;
            break;
        }
      });

      return $su;

    }


    public function conforms_to_scores_screen_rules() {
      $last_question_order= -1;

      //dd($this->questions()->where('title', '%%scores%%')->get());

      foreach ($this->questions()->where('title', '%%scores%%')->get() as $question) {
        if ($question->order == $last_question_order + 1) {
          return false;
        } else {
          $last_question_order = $question->order;
        }
      }
      return true;

    }

}

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
      return ($this->questions()->where('released', "0")->get()->count() == 0);
    }

    public function latest_unreleased() {
       return $this->questions()->get()->where('released', "0")->sortBy('order')->first();
    }

    public function get_participant_mark(User $user) {
      $mark = 0;
      $this->questions()->each(function ($question) use ($user, &$mark) {
         if (null != $question->responses->where('user_id', $user->id)->sortBy('created_at')->last() && $question->responses->where('user_id', $user->id)->sortBy('created_at')->last()->correct) {
           $mark++;
         }
       });
       return $mark;
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

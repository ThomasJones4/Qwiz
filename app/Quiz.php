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

}

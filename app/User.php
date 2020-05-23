<?php

namespace App;

use App\Quiz;
use App\Question;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function my_quizzes() {
      return $this->hasMany(Quiz::class);
    }

    public function quizzes() {
      return $this->belongsToMany(Quiz::class);
    }

    public function responses() {
      return $this->hasMany(Response::class);
    }


    public function question_responses(Question $question) {
      return $this->responses->where('question_id', $question->id);
    }


    public function have_i_answered(Question $question) {
      return (null != $this->responses->where('question_id', $question->id)->count() > 0);
    }

    public function correct_so_far(Quiz $quiz) {
      $count = 0;
      $quiz->questions->each(function ($question) use (&$count) {
        $question->responses->where('user_id', $this->id)->each(function ($response) use (&$count) {
          if ($response->correct == "1") {
            $count++;
            // IDEA: minus marking impliment here
          }
        });
      });
      return $count;
    }
}

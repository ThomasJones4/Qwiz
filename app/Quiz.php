<?php

namespace App;

use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function questions() {
      return $this->hasMany(Question::class);
    }

    public function user() {
      return $this->belongsTo(User::class);
    }
}

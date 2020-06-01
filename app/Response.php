<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{

    protected $fillable = ['user_id','answer'];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function question() {
      return $this->belongsTo(Question::class);
    }
}

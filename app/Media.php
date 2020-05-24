<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
  protected $fillable = ['question_id', 'url', 'type', 'extension'];

  public function question() {
    return $this->belongsTo(Question::class);
  }

}

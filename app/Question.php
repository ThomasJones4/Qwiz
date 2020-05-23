<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{

  public function quiz() {
    return $this->belongsTo(Quiz::class);
  }

  public function responses() {
    return $this->hasMany(Response::class);
  }

  public function have_i_answered() {
    return (null != $this->responses->where('user_id', Auth::user()->id)->count() > 0);
  }

  public function my_responses() {
    return $this->responses->where('user_id', Auth::user()->id);
  }

  public function correct() {
    return (null != $this->responses->where('user_id', Auth::user()->id)->last()->correct);
  }

  public function is_latest() {
    return ($this->order == $this->quiz->questions->sortBy('order')->where('released', 1)->last()->order);
  }

  public function latest() {
    return $this->quiz->questions->sortBy('order')->where('released', 1)->last()->order;
  }
}

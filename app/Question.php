<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{

  protected $fillable = ['title', 'question', 'order', 'correct_answer', 'possible_answers'];

  public function quiz() {
    return $this->belongsTo(Quiz::class);
  }

  public function responses() {
    return $this->hasMany(Response::class);
  }

  public function media() {
    return $this->hasMany(Media::class);
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
    if ($this->quiz->questions->sortBy('order')->where('released', 1)->count() != 0) {
      return ($this->order == $this->quiz->questions->sortBy('order')->where('released', 1)->last()->order);
    } else {
      return false;
    }
  }

  public function latest() {
    if ($this->quiz->questions->sortBy('order')->where('released', 1)->count() != 0) {
      return $this->quiz->questions->sortBy('order')->where('released', 1)->last()->order;
    } else {
      return null;
    }
  }

  public function next() {
    return (null != $this->quiz->questions->where('order', $this->order + 1)->first())
                                ? $this->quiz->questions->where('order', $this->order + 1)->first()
                                : "-1";
  }
}

<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        return view('quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }

    /**
     * get the progress of the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function progress(Quiz $quiz, Question $question)
    {

      // if next question, set variable else set -1
      $next_question = (null != $quiz->questions->sortBy('order')->where('order', $question->order + 1)->first())
                                  ? $quiz->questions->sortBy('order')->where('order', $question->order + 1)->first()
                                  : "-1";


      // TODO: replace $next_question->id with the url for the next question
      if ($next_question == "-1") {
          // no more questions
          return response()->json(["next" => null, "type" => null], 200);
      } else {
        // next question ready
        if ($next_question->title == "mid-scores") {
          // mid score waiting area next
          return response()->json(["next" => $next_question->id, "type" => 'mid-scores'], 200);
        } else if ($next_question->title == "mid-scores-results") {
          // mid score results next
          return response()->json(["next" => $next_question->id, "type" => 'mid-scores-results'], 200);
        } else if ($next_question->title == "end-scores") {
          // end score waiting next
          return response()->json(["next" => $next_question->id, "type" => 'end-scores'], 200);
        } else if ($next_question->title == "end-scores-results") {
          // end score results next
          return response()->json(["next" => $next_question->id, "type" => 'end-scores-results'], 200);
        } else {
          // next question ready
          return response()->json(["next" => $next_question->id, "type" => 'question'], 200);
        }
      }
    }


    /**
     * see if a quiz is ready
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function quiz_ready(Quiz $quiz)
    {
      $first_question = $quiz->questions->sortBy('order')->first();

      if ($first_question->released == "0") {
        return response()->json(["next" => null], 423);
      } else {
        return response()->json(["next" => $first_question->id], 200);
      }
    }
}

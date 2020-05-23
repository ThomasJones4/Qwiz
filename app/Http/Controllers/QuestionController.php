<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
    public function store(Request $request, Question $question)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
      // TODO: make into gate
      if ($question->released != '1') {
          $error_message = "This Question has not been released yet";
          return view('layouts.error', compact('error_message'));
      }

      $all_questions = $question->quiz->questions;

      $foyer = ['mid-scores','end-scores'];

      if (in_array($question->title, $foyer)) {
        $quiz = $question->quiz;
        return view('quiz.scoreboard.show_foyer', compact('quiz', 'question', 'all_questions'));
      } else {
        return view('question.show', compact('question', 'all_questions'));
      }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show_next(Question $question)
    {
        // TODO: make into gate
        if ($question->released != '1') {
            $error_message = "This Question has not been released yet";
            return view('layouts.error', compact('error_message'));
        }

        $all_questions = $question->quiz->questions;

        $answers = Auth::user()->responses()->where('question_id', $question->id)->get();

        $results = ['mid-scores','end-scores'];

        if (in_array($question->title, $results)) {
          $quiz = $question->quiz;

          $all_questions = $question->quiz->questions->where('order', '<', $question->order);

          return view('quiz.scoreboard.show_results', compact('quiz', 'question', 'all_questions'));
        }

        return view('question.foyer', compact('question', 'answers', 'all_questions'));
    }

    /**
     * get the progress of the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function next(Question $question, $force = false)
    {

      $quiz = $question->quiz;

      // if next question, set variable else set -1
      $next_question = (null != $quiz->questions->where('order', $question->order + 1)->first())
                                  ? $quiz->questions->where('order', $question->order + 1)->first()
                                  : "-1";


      // TODO: replace $next_question->id with the url for the next question
      if ($next_question == "-1") {
          // no more questions
          return response()->json(["next" => null, "type" => null], 200);

      } else if ($next_question->released != "0") {
        // next question ready
        if ($question->title == "mid-scores") {
          return response()->json(["next" => route('question.lobby', $question), "type" => 'mid-scores', 'btn_text' => 'View Score Break Results'], 200);
        } else if ($question->title == "end-scores") {
          // end score waiting next
          return response()->json(["next" => route('question.lobby', $question), "type" => 'end-scores', 'btn_text' => 'View End of Game Results'], 200);
        } else if ($next_question->title == "mid-scores") {
          return response()->json(["next" => route('question.show', $next_question), "type" => 'mid-scores', 'btn_text' => 'Submit for Score Break'], 200);
        } else if ($next_question->title == "end-scores") {
          // end score waiting next
          return response()->json(["next" => route('question.show', $next_question), "type" => 'end-scores', 'btn_text' => 'Submit for End of Game'], 200);
        } else {
          if ($force) {
          // next question ready
          return response()->json(["next" => route('question.show', $question), "type" => 'question', 'btn_text' => 'Next Question'], 200);
        } else {
          return response()->json(["next" => route('question.show', $next_question), "type" => 'question', 'btn_text' => 'Next Question'], 200);

        }
        }
      } else {
        if ($force) {
        // next question ready
        return response()->json(["next" => route('question.show', $question), "type" => 'question', 'btn_text' => 'Next Question'], 200);
        } else {
        return response()->json(["next" => route('question.show', $next_question), "type" => 'question', 'btn_text' => 'Next Question'], 200);

        }      }
    }


    /**
     * get the progress of the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function next_force(Question $question)
    {

      $quiz = $question->quiz;

      $next_question = (null != $quiz->questions->where('order', $question->order + 1)->first())
                                  ? $quiz->questions->where('order', $question->order + 1)->first()
                                  : "-1";


        // TODO: replace $next_question->id with the url for the next question
        if ($next_question != "-1") {
          return QuestionController::next($next_question, true);
        }

      }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}

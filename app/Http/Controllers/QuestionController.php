<?php

namespace App\Http\Controllers;

use App\Question;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
      $lobby = ['mid-scores','end-scores'];
      $results = ['mid-scores-results','end-scores-results'];

      if (in_array($question->title, $lobby)) {
        $quiz = $question->quiz;
        return view('quiz.scoreboard.show_lobby', compact('quiz', 'question'));
      } else if (in_array($question->title, $results)) {
        $quiz = $question->quiz;
        return view('quiz.scoreboard.show_results', compact('quiz', 'question'));
      } else {
        return view('question.show', compact('question'));
      }
    }

    /**
     * get the progress of the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function next(Question $question)
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
        if ($next_question->title == "mid-scores") {
          // mid score waiting area next
          return response()->json(["next" => route('question.show', $next_question), "type" => 'mid-scores', 'btn_text' => 'Submit for Score Break'], 200);
        } else if ($next_question->title == "mid-scores-results") {
          // mid score results next
          return response()->json(["next" => route('question.show', $next_question), "type" => 'mid-scores-results', 'btn_text' => 'View Score Break Results'], 200);
        } else if ($next_question->title == "end-scores") {
          // end score waiting next
          return response()->json(["next" => route('question.show', $next_question), "type" => 'end-scores', 'btn_text' => 'Submit for End of Game'], 200);
        } else if ($next_question->title == "end-scores-results") {
          // end score results next
          return response()->json(["next" => route('question.show', $next_question), "type" => 'end-scores-results', 'btn_text' => 'View Leaderboard'], 200);
        } else {
          // next question ready
          return response()->json(["next" => route('question.show', $next_question), "type" => 'question', 'btn_text' => 'Next Question'], 200);
        }
      } else {
          return response()->json(["next" => route('question.show', $next_question), "type" => 'question', 'btn_text' => 'Waiting for Quiz Master'], 423);
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

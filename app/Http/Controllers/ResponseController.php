<?php

namespace App\Http\Controllers;

use App\Response;
use App\Question;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ResponseController extends Controller
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
     * toggle if correct
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function mark_toggle(Response $response)
    {
      Gate::authorize('view_master', $response->question->quiz);

      $response->correct = !$response->correct;
      $response->save();

      return response()->json(["response" => $response->id, "correct" => $response->correct], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request, Question $question)
     {
       $validatedData = $request->validate([
         'answer' => 'required'
       ]);
       $response = new Response;
       $response->user_id = Auth::user()->id;
       $response->answer = $validatedData['answer'];
       //$response->save();
       $question->responses()->save($response);

       return redirect()->route('question.lobby', compact('question'));
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }

    /**
     * count the number of submissions so far for a question
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function count(Question $question)
    {

        if ($question->released != "1") {
          return response()->json([
            'count' => -1,
            'total' => -1,]);
        }

        $quiz = $question->quiz;
        $total_players = -1;
        $participants = [];
        $submitted = [];

        // get number of users for this quiz
        foreach($quiz->questions()->get() as $all_question) {
          $all_question->responses()->get()->each(function ($response) use (&$participants){
            $participants[$response->user->id] = 1;
          });
        }

        // get number of users for this question
        $question->responses()->get()->each(function ($response) use (&$submitted){
          $submitted[$response->user->id] = 1;
        });

        return response()->json([
          'count' => count($submitted),
          'total' => count($participants),]);
    }
}

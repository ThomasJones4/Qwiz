<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Faker\Factory as Factory;
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
        return view('quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'name' => 'required',
        'scheduled_start' => 'required',
      ]);
      $faker = Factory::create();
      $validatedData['invite_code'] = $faker->randomNumber(8);

      $new_quiz = Auth::user()->my_quizzes()->create($validatedData);

      return redirect()->route('quiz.master.show', $new_quiz);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
      Gate::authorize('view', $quiz);

      return view('quiz.show', compact('quiz'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show_master(Quiz $quiz)
    {
      Gate::authorize('view_master', $quiz);

      return view('quiz.master.show', compact('quiz'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function index_mine()
    {
      $owned_quizzes = Auth::user()->my_quizzes()->get();
      $participant_quizzes = Auth::user()->quizzes()->get();
      return view('quiz.my_index', compact('owned_quizzes', 'participant_quizzes'));
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
     * see if a quiz is ready
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function quiz_ready(Quiz $quiz)
    {
      Gate::authorize('view', $quiz);

      $first_question = $quiz->questions->sortBy('order')->first();

      if ($first_question->released == "0") {
        return response()->json(["next" => null], 423);
      } else {
        return response()->json(["next" => route('question.show', $first_question) ], 200);
      }
    }

    /**
     * join a quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function join(Request $request, Quiz $quiz)
    {
      $validatedData = $request->validate([
        'invite_code' => [
          'required',
          'digits:8',
          function ($attribute, $value, $fail) use ($quiz) {
              if ($value != $quiz->invite_code) {
                  $fail('The invite code is not valid.');
              }
          },
          function ($attribute, $value, $fail) use ($quiz) {
              Auth::user()->quizzes()->each(function ($user_quiz) use ($quiz, $fail) {
                if ($user_quiz->invite_code == $quiz->invite_code) {
                  $fail('You have already joined this quiz');
                }
              });
          },
          function ($attribute, $value, $fail) use ($quiz) {
              if (Auth::user()->id == $quiz->id) {
                  $fail('This is your quiz');
              }
          }],
      ]);

      Auth::user()->quizzes()->attach($quiz);

      return redirect()->route('quiz.show', compact('quiz'));
    }

    /**
     * show join a quiz page
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function show_join(Quiz $quiz)
    {
      return view('quiz.join', compact('quiz'));
    }
}

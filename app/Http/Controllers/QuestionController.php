<?php

namespace App\Http\Controllers;

use App\Question;
use App\Quiz;
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
     * move the question up a level
     *
     * @return \Illuminate\Http\Response
     */
    public function move_up(Question $question)
    {

        Gate::authorize('move_up', $question);

        $questions = $question->quiz->questions->sortBy('order');

        $question_innocent = $questions->where('order', $question->order - 1)->first();
        $question_innocent->order++;
        $question_innocent->save();
        $question->order--;
        $question->save();

        return redirect()->back();

    }

    /**
     * move the question down a level
     *
     * @return \Illuminate\Http\Response
     */
    public function move_down(Question $question)
    {

      Gate::authorize('move_down', $question);

      $questions = $question->quiz->questions->sortBy('order');

      $question_innocent = $questions->where('order', $question->order + 1)->first();
      $question_innocent->order--;
      $question_innocent->save();
      $question->order++;
      $question->save();

      return redirect()->back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Quiz $quiz)
    {
      return view('question.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quiz $quiz)
    {
      Gate::authorize('view_master', $quiz);


      $validatedData = $request->validate([
        'title' => 'required',
        'question' => 'required',
        'correct_answer' => '',
      ]);

      $validatedData['order'] = ($quiz->questions()->get()->count() > 0)
          ? $quiz->questions->sortBy('order')->last()->order + 1
          : 0 ;

      $quiz->questions()->create($validatedData);

      return redirect()->route('quiz.master.show', $quiz);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {

      Gate::authorize('view', $question);

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
    public function master(Question $question)
    {

      Gate::authorize('view_master', $question->quiz);

      $all_questions = $question->quiz->questions;

      return view('question.master.show', compact('question', 'all_questions'));

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show_next(Question $question)
    {
        Gate::authorize('view', $question);

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
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function master_next(Question $question)
    {
        Gate::authorize('view_master', $question->quiz);

        $next_question = $question->next();
        if ($next_question != "-1") {
          $all_questions = $question->quiz->questions;

          $next_question->released = "1";
          $next_question->save();
          $question = $next_question;
          return view('question.master.show', compact('question', 'all_questions'));
        } else {
          dd('end the quiz?');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function master_this(Question $question)
    {
        Gate::authorize('view_master', $question->quiz);

        $all_questions = $question->quiz->questions;

        $question->released = "1";
        $question->save();

        $question = $question;
        return redirect()->route('question.master', compact('question', 'all_questions'));
    }

    /**
     * get the progress of the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function next(Question $question, $force = false)
    {

      Gate::authorize('view', $question);
      //dd(Auth::user());
      $quiz = $question->quiz;

      // if next question, set variable else set -1
      $next_question = (null != $quiz->questions->where('order', $question->order + 1)->first())
                                  ? $quiz->questions->where('order', $question->order + 1)->first()
                                  : "-1";


      // TODO: replace $next_question->id with the url for the next question
      if ($next_question == "-1") {
          // no more questions
          return response()->json(["next" => null, "type" => null], 200);

      } else if ($next_question->released == "1") {
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
        return response()->json(["next" => null, "type" => 'question', 'btn_text' => 'Waiting for Quiz Master'], 423);

        }
      }
    }
    /**
     * get the progress of the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function master_progress_next(Question $question)
    {
      Gate::authorize('view_master', $question->quiz);

      $quiz = $question->quiz;

      // if next question, set variable else set -1
      $next_question = (null != $quiz->questions->where('order', $question->order + 1)->first())
                                  ? $quiz->questions->where('order', $question->order + 1)->first()
                                  : "-1";


      // TODO: replace $next_question->id with the url for the next question
      if ($next_question == "-1") {
          // no more questions
          return response()->json(["next" => null, "type" => null], 200);

      } else if ($question->released == "1") {
        return response()->json(["next" => route('question.master', $next_question), "type" => 'question', 'btn_text' => 'Next Question'], 200);
      } else if ($question->released == "0" && $quiz->questions->sortBy('order')->where('released', "1")->count() == $question->order) {
        return response()->json(["next" => route('question.master.this', $question), "type" => 'question', 'btn_text' => 'Release This Question'], 200);
      } else {
        $next_to_be_released = $quiz->questions->sortBy('order')->where('released', "0")->first();
        return response()->json(["next" => route('question.master', $next_to_be_released), "type" => 'question', 'btn_text' => 'Go to first unreleased question'], 200);
      }
    }


    /**
     * get the progress of the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function next_force(Question $question)
    {

      Gate::authorize('view', $question->quiz);

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
        Gate::authorize('view_master', $question);

        return view('question.edit', compact('question'));
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
      Gate::authorize('view_master', $question);

      $validatedData = $request->validate([
        'title' => 'required',
        'question' => 'required',
        'correct_answer' => '',
      ]);

      $question->update($validatedData);

      return redirect()->route('quiz.master.show', $question->quiz);
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

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
        if ($question_innocent->released == "1" || $question->released == "1" ) {
          return redirect()->back();
        }
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
      if ($question_innocent->released == "1" || $question->released == "1" ) {
        return redirect()->back();
      }
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
     * create and add a results break
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_score_break(Request $request, Quiz $quiz)
    {
      Gate::authorize('view_master', $quiz);

      $scores = [];
      $scores['title'] = 'scores';
      $scores['question'] = '-';
      $scores['correct_answer'] = '-';

      $scores['order'] = ($quiz->questions()->get()->count() > 0)
          ? $quiz->questions->sortBy('order')->last()->order + 1
          : 0 ;

      $quiz->questions()->create($scores);

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

      $all_questions = $question->quiz->questions->sortBy('order');

      if ($question->title == "scores") {
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

      $all_questions = $question->quiz->questions->sortBy('order');

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

        $all_questions = $question->quiz->questions->sortBy('order');

        $answers = Auth::user()->responses()->where('question_id', $question->id)->get();


        // QUESTION: 0001;
        if ($question->title == 'scores') {
          $quiz = $question->quiz;

          $all_questions = $question->quiz->questions->where('order', '<', $question->order)->sortBy('order');

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
    public function master_next_del(Question $question)
    {
        Gate::authorize('view_master', $question->quiz);

        $next_question = $question->next();
        if ($next_question != "-1") {
          $all_questions = $question->quiz->questions->sortBy('order');

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

        $all_questions = $question->quiz->questions->sortBy('order');

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

      $quiz = $question->quiz;
      $current_question = $question;

      Gate::authorize('view', $quiz);

      // if next question, set variable else set -1
      $next_question = $quiz->questions->where('order', $current_question->order + 1)->sortBy('order')->first();

      if (null == $next_question) {
        // no more Questions
        // return button to view the game overview

        return response()->json(["next" => route('quiz.overview', $quiz), "type" => 'end_of_quiz', 'btn_text' => 'Go To Game Overview'], 200);

      }

      if ($next_question->title == 'scores') {
        if ($next_question->released) {
          // if the next question is scores and its been released (QM has marked and released)
          // then send user stright to the scores waiting area where the results will be displayed

          // TODO: in blade for lobby, if lobby for results so results page
          return response()->json(["next" => route('question.lobby', $next_question), "type" => 'scores', 'btn_text' => 'View results'], 200);

        } else {
          // next question is scores but has not been released so
          // show user button 'qm is marking'

          return response()->json(["next" => null, "type" => 'waiting', 'btn_text' => 'Question Master is marking the quiz'], 423);

        }
      }

      if ($next_question->released) {
        // next question has been released so show link to go to next question

        return response()->json(["next" => route('question.show', $next_question), "type" => 'next_question', 'btn_text' => 'Next Question'], 200);

      } else {
        // next question has not been released

        return response()->json(["next" => null, "type" => 'waiting', 'btn_text' => 'Waiting for next question to be released'], 423);

      }

      return response()->json(["next" => null, "type" => 'waiting', 'btn_text' => 'default [9d2g5kam]'], 423);

    }

    /**
     * get the next question action link for the backend
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function master_next(Question $question)
    {

      $quiz = $question->quiz;

      Gate::authorize('view_master', $quiz);

      $next_question = $quiz->questions->where('order', $question->order + 1)->sortBy('order')->first();
      $latest_question = $quiz->questions->where('released')->sortBy('order')->last();
      $latest_next_question = $quiz->questions->where('released', "0")->sortBy('order')->first();
      $current_question = $question;

      if (null == $next_question && $current_question->released) {
        // no more Questions
        // return button to view the game overview

        return response()->json(["next" => route('quiz.overview', $quiz), "type" => 'end_of_quiz', 'btn_text' => 'Go To Game Overview'], 200);

      }

      if ($current_question->title == 'scores') {
          // next question is scores but has not been released so
          // show master the 'mark answers' button

          return response()->json(["next" => route('quiz.mark', $quiz), "type" => 'mark', 'btn_text' => 'Mark answers'], 200);

        }


      if (($current_question->released && $current_question->order < $latest_question->order)
        || (!$current_question->released && $current_question->order > $latest_question->order + 1)) {
        // this question has been released and isnt the latest -> link to latest question

        return response()->json(["next" => route('question.master', $latest_question), "type" => 'latest_question', 'btn_text' => 'Go to latest Question'], 200);

      }

      if (!$current_question->released && $current_question->order == $latest_next_question->order) {
        // this question has not been released and is the latest -> link to release

        return response()->json(["next" => route('question.master.this', $current_question), "type" => 'release', 'btn_text' => 'Release this question'], 200);

      }



      return response()->json(["next" => route('question.master', $next_question), "type" => 'next_question', 'btn_text' => 'Next question [9d2g5kam]'], 200);


    }





    /**
     * force the next question to be returned (called from results pages only)
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function next_force(Question $question)
    {

      $quiz = $question->quiz;

      Gate::authorize('view', $quiz);

      $next_question = (null != $quiz->questions->where('order', $question->order + 1)->sortBy('order')->first())
                                  ? $quiz->questions->where('order', $question->order + 1)->sortBy('order')->first()
                                  : "-1";


        // TODO: replace $next_question->id with the url for the next question
        if ($next_question != "-1") {
          return QuestionController::next($next_question, true);
        } else {

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

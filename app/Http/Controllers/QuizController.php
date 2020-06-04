<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image as Image;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quiz_header(Quiz $quiz)
    {
      $x = 454;
      $y = 320;
      $img = Image::canvas($x, $y, '#ddd');
      $img->insert(resource_path().'\images\qwiz_gradient_background.png');
      // draw a blue line

      $img->text('Qwiz.co.uk', $x/2, $y/6, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(60);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      $y = $y + 200;
      $img->text($quiz->quiz_master->name, $x/2, $y/4, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(30);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      $img->text('as invited tou to join their quiz', $x/2, $y/4+40, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(20);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      $img->text($quiz->name, $x/2, $y/4+65, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(30);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      $img->text('@ '. $quiz->scheduled_start, $x/2, $y/4+100, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(20);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      return response($img->encode('png'))->header('Content-Type', 'image/png');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function social_header()
    {

      $x = 454;
      $y = 320;
      $img = Image::canvas($x, $y, '#ddd');
      $img->insert('../../../resources\images\qwiz_gradient_background.png');
      // draw a blue line

      $img->text('Qwiz.co.uk', $x/2, $y/6, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(60);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      $img->text('Create quizzes and play live with friends.', $x/2, $y/2, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(20);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      $img->text('Bring your own or genarate random questions', $x/2, $y/2+30, function($font) {
          $font->file(resource_path().'\fonts\Open_Sans\OpenSans-SemiBold.ttf');
          $font->size(20);
          $font->color('#fff');
          $font->align('center');
          $font->valign('top');
          $font->angle(0);
      });

      return response($img->encode('png'))->header('Content-Type', 'image/png');
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

      $validatedData['invite_code'] = rand(10000001, 99999999);

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
      Gate::authorize('editable', $quiz);

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
     * start the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function start(Quiz $quiz)
    {
      Gate::authorize('view_master', $quiz);

      $first_question = $quiz->questions->sortBy('order')->first();

      $first_question->released = "1";
      $first_question->save();
      $quiz->invite_code = null;
      $quiz->save();

      return redirect()->route('question.master', $first_question);
    }

    /**
     * finish the quiz
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public static function finish(Quiz $quiz)
    {
      Gate::authorize('view_master', $quiz);

      $quiz->invite_code = null;
      $quiz->save;

      dd('idealy an, now default, end screen showing what happend etc..');
    }


    /**
     * show marking screen for questions so far
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function mark(Quiz $quiz)
    {

      Gate::authorize('view_master', $quiz);

      $all_questions = $quiz->questions->where('released', "1")->sortBy('order');

      return view('quiz.master.marking', compact('quiz', 'all_questions'));

    }

    /**
     * complete marking screen for first unreleased score question
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function mark_finish(Quiz $quiz)
    {

      Gate::authorize('view_master', $quiz);

      $first_unreleased = $quiz->questions->where('released', "0")->sortBy('order')->first();

      // if marking has already been done / quiz already finished, go to overview
      if (null == $first_unreleased) {
        return redirect()->route('quiz.overview', $quiz);
      }

      $first_unreleased->released = "1";
      $first_unreleased->save();
      $first_unreleased = $quiz->questions->where('released', "0")->sortBy('order')->first();

      // if no more question left, go to overview
      if (null == $first_unreleased) {
        return redirect()->route('quiz.overview', $quiz);
      }


      return redirect()->route('question.master', $first_unreleased);

    }
    /**
     * complete marking screen for first unreleased score question
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function overview(Quiz $quiz)
    {

      Gate::authorize('view', $quiz);

      // sort users by total
      $su = [];
      $su = $quiz->users->each(function($user) use ($quiz, &$su) {
            $user['total'] = $quiz->get_participant_mark($user);
        });
      $su = $su->sortByDesc('total');

      $first_place_threshold = $su->first()->total;

      $second_place_threshold = $su->where('total', '<', $first_place_threshold)->first();
      $second_place_threshold = (null != $second_place_threshold)? $second_place_threshold->total : $first_place_threshold;

      $third_place_threshold = $su->where('total', '<', $second_place_threshold)->first();
      $third_place_threshold = (null != $third_place_threshold)? $third_place_threshold->total : $second_place_threshold;

      $penultimate_place_threshold = $su->where('total', '<', 'third_place_threshold')->sortBy('total')->first();
      $penultimate_place_threshold = (null != $penultimate_place_threshold)? $penultimate_place_threshold->total : 1;
      //
      // $penultimate_place_threshold = $su->where('total', '=', $smallest_total)->sortBy('total')->skip(1)->take(1)->first();
      // $penultimate_place_threshold = (null != $penultimate_place_threshold)? $penultimate_place_threshold->total : -1;

      //dd( compact('first_place_threshold', 'second_place_threshold', 'third_place_threshold', 'penultimate_place_threshold'));

      return view('quiz.overview', compact('quiz', 'su', 'first_place_threshold', 'second_place_threshold', 'third_place_threshold', 'penultimate_place_threshold'));
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

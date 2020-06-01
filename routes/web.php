<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

  Route::get('quizzes/mine', 'QuizController@index_mine')->name('show.my.quiz');
  Route::get('quizzes/{quiz}/master', 'QuizController@show_master')->name('quiz.master.show');

  Route::resource('quizzes', 'QuizController', ['only' => ['show', 'create', 'store']])->names([
    'show' => 'quiz.show']);

  Route::get('quizzes/{quiz}/questions/create', 'QuestionController@create')->name('quiz.question.create');
  Route::get('quizzes/{quiz}/questions/create/score-break', 'QuestionController@create_score_break')->name('quiz.question.create.score.break');
  Route::get('quizzes/{quiz}/start', 'QuizController@start')->name('quiz.start');
  Route::get('quizzes/{quiz}/finish', 'QuizController@finish')->name('quiz.finish');
  Route::get('quizzes/{quiz}/overview', 'QuizController@overview')->name('quiz.overview');
  Route::get('quizzes/{quiz}/marking', 'QuizController@mark')->name('quiz.mark');
  Route::get('quizzes/{quiz}/marking/complete', 'QuizController@mark_finish')->name('quiz.finish.marking');
  Route::post('quizzes/{quiz}/questions', 'QuestionController@store')->name('quiz.question.store');
  Route::get('questions/{question}/up', 'QuestionController@move_up')->name('question.move.up');
  Route::get('questions/{question}/down', 'QuestionController@move_down')->name('question.move.down');

  Route::get('questions/{question}/media/create', 'MediaController@create')->name('media.create');
  Route::post('questions/{question}/media', 'MediaController@store')->name('media.store');
  Route::get('questions/{question}/media/{media}/destroy', 'MediaController@destroy')->name('media.delete');

  Route::resource('questions', 'QuestionController', ['only' => ['show', 'edit', 'update']])->names([
    'show' => 'question.show',
    ]);

  Route::get('questions/{question}/next', 'QuestionController@show_next')->name('question.lobby');
  Route::get('questions/{question}/master', 'QuestionController@master')->name('question.master');
  Route::get('questions/{question}/master/next', 'QuestionController@master_next')->name('question.master.next');
  Route::get('questions/{question}/master/this', 'QuestionController@master_this')->name('question.master.this');

  Route::post('question/{question}/responses/store', 'ResponseController@store')->name('store.response');


  Route::get('join/{quiz}', 'QuizController@show_join')->name('show.join.quiz');
  Route::get('🎲/{quiz}', function ($quiz) {
      return redirect(route('show.join.quiz', $quiz));
  })->name('show.join.quiz.emoji');
  Route::post('join/{quiz}', 'QuizController@join')->name('join.quiz');
});

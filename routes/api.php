<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Quiz;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {

  Route::get('quizzes/{quiz}/progress', 'QuizController@quiz_ready')->name('quiz_ready');
  Route::get('questions/{question}/progress', 'QuestionController@next')->name('next_question');
  Route::get('questions/{question}/master/progress/next', 'QuestionController@master_progress_next')->name('master_progress_next');
  Route::get('questions/{question}/master/progress/next', 'QuestionController@master_next')->name('master_next');
  Route::get('questions/{question}/progress/force', 'QuestionController@next_force')->name('next_question_results');
  Route::get('questions/{question}/responses/count', 'ResponseController@count')->name('response.count');
  Route::get('quizzes/{quiz}/count', 'QuizController@count')->name('quiz.player.count');
  Route::get('quizzes/{quiz}/players/get', 'QuizController@players_get')->name('quiz.player.get');
  Route::get('responses/{response}/toggle', 'ResponseController@mark_toggle')->name('response.mark_toggle');

});

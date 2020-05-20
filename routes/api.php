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


  Route::get('quizzes/{quiz}/progress', 'QuizController@quiz_ready')->name('quiz_ready');
  Route::get('quizzes/{quiz}/progress/{question}', 'QuizController@progress')->name('progress');

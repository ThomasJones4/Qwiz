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

  Route::resource('quizzes', 'QuizController', ['only' => ['show']])->names([
    'show' => 'quiz.show']);

  Route::resource('questions', 'QuestionController', ['only' => ['show']])->names([
    'show' => 'question.show',
    ]);

  Route::get('questions/{question}/next', 'QuestionController@show_next')->name('question.lobby');

  Route::post('question/{question}/responses/store', 'ResponseController@store')->name('store.response');


  Route::get('join/{quiz}', 'QuizController@show_join')->name('show.join.quiz');
  Route::post('join/{quiz}', 'QuizController@join')->name('join.quiz');
});

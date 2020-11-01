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

Route::get('/createquizz', function () {
    return view('createquizz');
})->name('quizz-create');

Route::get('/playquizz', function () {
    return view('playquizz');
})->name('quizz-play');

Route::get('/myquizz', function () {
    return view('myquizz');
})->name('user-quizz');


Route::post('/savequizz','\App\Http\Controllers\QuizzsController@saveQuizz');
Route::post('/dropquizz/{quizzid}','\App\Repositories\QuizzRepository@dropQuizz');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

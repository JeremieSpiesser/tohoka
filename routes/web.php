<?php

use App\Events\PrivateTestEvent;
use App\Events\TestEvent;
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

Route::get('/modifyquizz', function () {
    return view('modifyquizz');
})->name('quizz-modify');


Route::post('/savequizz','\App\Http\Controllers\QuizzsController@saveQuizz');
Route::post('/modQuizz','\App\Http\Controllers\QuizzsController@modifyQuizz');
Route::post('/dropquizz/{quizzid}','\App\Repositories\QuizzRepository@dropQuizz');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/chat', function (){
    return view('testchat');
});

Route::post('/postMsg', [App\Http\Controllers\Message\PostMessageController::class, 'handle']);

Route::get('/fire', function () {
    event(new TestEvent());
    return 'ok pub';
});

Route::get('/fire-priv', function () {
    event(new PrivateTestEvent());
    return 'ok priv';
});

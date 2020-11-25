<?php

use App\Events\PrivateTestEvent;
use App\Events\TestEvent;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

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

Route::get('/createquizz', '\App\Http\Controllers\QuizzsUIController@createQuizz')
    ->middleware('auth')
    ->name('quizz-create');

Route::get('/playquizz/{id}', '\App\Http\Controllers\QuizzsUIController@playQuizz')
    ->middleware('auth')
    ->name('quizz-play');

Route::get('/myquizz', '\App\Http\Controllers\QuizzsUIController@myQuizz')
    ->middleware('auth')
    ->name('user-quizz');

Route::get('/modifyquizz/{id}', '\App\Http\Controllers\QuizzsUIController@modifyQuizz')
    ->middleware('auth')
    ->name('quizz-modify');


Route::post('/savequizz','\App\Http\Controllers\QuizzsAPIController@saveQuizz')
    ->middleware('auth')
    ->name('quizz-api-save');

Route::post('/modQuizz/{id}','\App\Http\Controllers\QuizzsAPIController@modifyQuizz')
    ->middleware('auth')
    ->name('quizz-api-modify');

Route::get('/dropquizz/{id}','\App\Http\Controllers\QuizzsAPIController@dropQuizz')
    ->middleware('auth')
    ->name('quizz-api-drop');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/play/{id}', function ($id){
    return view('testchat', ['id' => $id]);
});

Route::post('/message', [App\Http\Controllers\Message\PostMessageController::class, 'handle']);

Route::post('/broadcasting/auth', function (){
    if (request()->hasSession()) {
        request()->session()->reflash();
    }

    if(!Auth::check()){
        $user = new GenericUser(['id' => Uuid::uuid4()]);

        request()->setUserResolver(function () use ($user) {
            return $user;
        });
    }

    Session::put('generic_user', request()->user());

    return Broadcast::auth(request());
});

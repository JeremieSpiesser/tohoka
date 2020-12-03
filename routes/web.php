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
    ->name('quizz-play');

Route::get('/getquizzquestion/{quizzId},{questionId}', '\App\Http\Controllers\QuizzsUIController@getQuizzQuestion')
    ->name('get-quizz-question');

Route::get('/registerPlayer', '\App\Http\Controllers\AnswersAPIController@registerPlayer')
    ->middleware('auth')
    ->name('register-player');

Route::get('/foo', '\App\Http\Controllers\AnswersAPIController@foo')
    ->name('foo');

Route::post('/registerAnswer', '\App\Http\Controllers\AnswersAPIController@registerAnswer')
    ->middleware('auth')
    ->name('register-answer');

Route::post('/registerToInstance', '\App\Http\Controllers\AnswersAPIController@registerToInstance')
    ->middleware('auth')
    ->name('register-to-instance');

Route::get('/createInstance', '\App\Http\Controllers\InstanceAPIController@createInstance')
    ->middleware('auth')
    ->name('create-instance');

Route::get('/play', '\App\Http\Controllers\InstanceAPIController@joinInstance')
    ->middleware('auth')
    ->name('join-instance');

Route::get('/registerInstance', '\App\Http\Controllers\InstancesAPIController@registerInstance')
    ->middleware('auth')
    ->name('register-instance');

Route::get('/myquizz', '\App\Http\Controllers\QuizzsUIController@myQuizz')
    ->middleware('auth')
    ->name('user-quizz');

Route::get('/allquizz', '\App\Http\Controllers\QuizzsUIController@allQuizz')
    ->name('all-quizz');

Route::get('/modifyquizz/{id}', '\App\Http\Controllers\QuizzsUIController@modifyQuizz')
    ->middleware('auth')
    ->name('quizz-modify');


Route::post('/savequizz','\App\Http\Controllers\QuizzsAPIController@saveQuizz')
    ->middleware('auth')
    ->name('quizz-api-save');

Route::post('/submitAnswer','\App\Http\Controllers\QuizzsAPIController@submitQuestionAnswer')
    ->name('quizz-submit-question');

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

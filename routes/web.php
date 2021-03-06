<?php

use App\Events\UserStateChanged;
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

Route::get('/state/{a}/{q}', function (Request $req, $a, $q){
    if(!Session::has('current_instance') || !Session::has('generic_user')){
        abort(404);
    }
    $msg = "";
    switch($a){
        case "load":
            $msg = "Question " . $q . " : En train de répondre ...";
            break;
        case "finish":
            $msg = "Question " . $q . " : A répondu ...";
            break;
    }

    broadcast(new UserStateChanged(Session::get('current_instance'), Session::get('generic_user')->id, $msg));
});

Route::get('/createquizz', '\App\Http\Controllers\QuizzsUIController@createQuizz')
    ->middleware('auth')
    ->name('quizz-create');

Route::get('/getquizzquestion/{quizzId},{questionId}', '\App\Http\Controllers\QuizzsUIController@getQuizzQuestion')
    ->name('get-quizz-question');

Route::get('/playquizz/{id}', '\App\Http\Controllers\QuizzsUIController@playQuizz')
    ->name('quizz-play');


Route::get('/registerPlayer', '\App\Http\Controllers\AnswersAPIController@registerPlayer')
    ->middleware('auth')
    ->name('register-player');

Route::get('/registerPlayer', '\App\Http\Controllers\AnswersAPIController@registerPlayer')
    ->middleware('auth')
    ->name('register-player');

Route::get('/foo', '\App\Http\Controllers\AnswersAPIController@foo')
    ->name('foo');

Route::post('/registerAnswer', '\App\Http\Controllers\AnswersAPIController@registerAnswer')
    ->name('register-answer');

Route::get('/play/{idInstance}', '\App\Http\Controllers\AnswersAPIController@registerToInstance')
        ->name('register-to-instance');

Route::get('/play', '\App\Http\Controllers\InstanceAPIController@joinInstance')
    ->name('join-instance');

Route::post('/openNextQuestion', '\App\Http\Controllers\InstanceAPIController@openNextQuestion')
    ->middleware('auth')
    ->name('open-next-question');

Route::get('/createInstance', '\App\Http\Controllers\InstanceAPIController@createInstance')
    ->middleware('auth')
    ->name('create-instance');

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

Route::get('/chat/{id}', function ($id){
    return view('testchat', ['id' => $id]);
});

Route::post('/message', [App\Http\Controllers\Message\PostMessageController::class, 'handle']);

Route::post('/broadcasting/auth', function (){
    if (request()->hasSession()) {
        request()->session()->reflash();
    }

    return Broadcast::auth(request());
});

Route::post('/upload', [App\Http\Controllers\UploadController::class,'handleUpload'])->middleware('auth');

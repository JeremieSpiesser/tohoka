<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use App\Repositories\QuizzRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuizzsUIController extends Controller
{

    function createQuizz(){
        return view('createquizz');
    }

    function myQuizz(){
        return view('myquizz', ['quizzs' => QuizzRepository::findByUID()]);
    }

    function allQuizz(){
        return view('allquizz', ['quizzs' => QuizzRepository::findAllQuizzs()]);
    }

    function modifyQuizz($id){
        $quizz = Quizz::where('id', $id)->where('creator', Auth::id())->firstOrFail();
        return view('modifyquizz', ['quizz' => $quizz]);
    }

    function playQuizz($id){
        $quizz = Quizz::where('id', $id)->where('creator', Auth::id())->firstOrFail();
        $quizz->bgm = Storage::url($quizz->bgm);
        return view('playquizz', ['quizz' => $quizz]);
    }
}

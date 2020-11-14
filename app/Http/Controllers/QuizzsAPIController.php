<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class QuizzsAPIController extends Controller
{
    public function saveQuizz(){

        $quizz = new Quizz();

        $quizz->name = request('name');
        $quizz->content = request('content');
        $quizz->creator = Auth::id();

        $quizz->save();

        return Redirect::route('user-quizz');
    }

    public function modifyQuizz($id){
        $quizz = Quizz::where('id', $id)->where('creator', Auth::id())->firstOrFail();

        $quizz->name = request('name');
        $quizz->content = request('content');

        $quizz->save();

        return Redirect::route('user-quizz');
    }

    public function dropQuizz($id){
        Quizz::where('id', $id)->where('creator', Auth::id())->delete();
        return Redirect::back();
    }
}
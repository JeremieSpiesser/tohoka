<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizzsController extends Controller
{
    public function saveQuizz(){

        $quizz = new \App\Models\Quizz();

        $quizz->name = request('name');
        $quizz->content = request('content');
        $quizz->creator = Auth::id();

        $quizz->save();

        return redirect('/');

    }
}

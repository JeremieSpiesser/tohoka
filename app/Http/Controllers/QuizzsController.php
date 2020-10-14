<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizzsController extends Controller
{
    public function saveQuizz(){

        $quizz = new \App\Models\Quizz();

        $quizz->name = request('name');
        $quizz->content = request('content');
        //$quizz->creator = request('creator');

        $quizz->save();

        return redirect('/');

    }
}

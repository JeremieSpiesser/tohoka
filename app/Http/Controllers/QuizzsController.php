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

        return redirect('/myquizz');
    }
    public function modifyQuizz(){

        $name = request('name');
        $content = request('content');
        $id = request('id');
        $update=\DB::table('quizzs')
            ->where('id',$id)
            ->update(['content'=>$content],['name'=>$name],['updated_at'=>date('yy-m-d h:i:s')]);
        return redirect('/myquizz');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class QuizzsAPIController extends Controller
{
    public function saveQuizz(Request $request){

        $quizz = new Quizz();

        $quizz->name = request('name');
        $quizz->content = request('content');
        $quizz->creator = Auth::id();

        if ($request->bgm != null)
        {
            $path = $request->bgm->store('public');
            $quizz->bgm = $path;
        }

        $quizz->save();

        return Redirect::route('user-quizz');
    }

    public function modifyQuizz(Request $request, $id){
        $quizz = Quizz::where('id', $id)->where('creator', Auth::id())->firstOrFail();

        $quizz->name = request('name');
        $quizz->content = request('content');

        if ($request->bgm != null)
        {
            $path = $request->bgm->store('public');
            $quizz->bgm = $path;
        }

        $quizz->save();

        return Redirect::route('user-quizz');
    }

    public function dropQuizz($id){
        Quizz::where('id', $id)->where('creator', Auth::id())->delete();
        return Redirect::back();
    }
}

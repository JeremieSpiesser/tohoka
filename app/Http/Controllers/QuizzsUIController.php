<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use App\Repositories\QuizzRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Str;

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
        $quizz = QuizzRepository::playQuizz($id);
        $quizz->bgm = Storage::url($quizz->bgm);
        if($quizz->bgm == 'storage' || !Str::contains($quizz->bgm, '.')){
            $quizz->bgm = "";
        }
        return view('playquizz', ['quizz' => $quizz]);
    }

    function getQuizzQuestion($quizzId, $questionId){
        $quizz = json_decode(QuizzRepository::playQuizz($quizzId)['content'], true);

        if (is_null($quizz["items"][$questionId]))
            return view('errorLoadingQuestion', ['error' => "bad question id"]);

        $answers = array();
        foreach ($quizz["items"][$questionId]["answers"] as $answer){
            $answers[] = $answer["answer"];
        }

        //var_dump($quizz["items"][$questionId]["question"]);
        $question = json_encode([
            "question" => $quizz["items"][$questionId]["question"],
            "answers" => $answers,
            "type" => $quizz["items"][$questionId]["type"]
        ]);

        return response()->json($question);
    }

    function submitQuestionAnswer(){
        return 0; // TODO
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use App\Repositories\QuizzRepository;
use App\Repositories\InstanceRepository;
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

    static function playQuizz($id, int $idInstance = -1){
        $quizz = QuizzRepository::playQuizz($id);
        $quizz->bgm = Storage::url($quizz->bgm);
        if($quizz->bgm == 'storage' || !Str::contains($quizz->bgm, '.')){
            $quizz->bgm = "";
        }
        $quizz->number = count(json_decode($quizz['content'], true)['items']);
        if ($idInstance > -1)
            $quizz->idInstance = $idInstance;
        return view('playquizz', ['quizz' => $quizz]);
    }

    function getQuizzQuestion($instanceId, $questionId){

        $quizzId = InstanceRepository::getQuizzId($instanceId);

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

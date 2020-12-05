<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Quizz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$DEFAULT_QUESTION_DURATION = 15;

/**
 * Class QuizzRepository
 * @package App\Repositories
 */
class QuizzRepository
{
    public static function findByUID(){
        return Quizz::where('creator', Auth::id())->get();
    }

    public static function findAllQuizzs(){
        if (Auth::check())
            return Quizz::where('creator', Auth::id())->orWhere('private', '>=', 1)->get();
        else
            return Quizz::where('private', 2)->get();
    }

    public static function playQuizz($id){
        return Quizz::where('id', $id)->where(function($query) {
            if(Auth::check()){
                $query->where('creator', Auth::id());
            }
            $query->orWhere('private', '>=', (Auth::check() ? 1 : 2));
        })->firstOrFail();
    }

    public static function getQuestionDuration($quizzId, $questionId)
    {
        $duration = json_decode(playQuizz($id)['content'], true)['items'][$questionId]['duration'];

        return $duration >= 1 ? $duration : $GLOBALS['DEFAULT_QUESTION_DURATION'];
    }
}

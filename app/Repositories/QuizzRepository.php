<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Quizz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

    public static function getQuestionCount($id){
        $quizz = Quizz::where('id', $id)->where(function($query) {
            if(Auth::check()){
                $query->where('creator', Auth::id());
            }
            $query->orWhere('private', '>=', (Auth::check() ? 1 : 2));
        })->firstOrFail()['content'];

        return count(json_decode($quizz, true)['items']);
    }

    public static function getQuestionDuration($quizzId, $questionId)
    {
        $question = json_decode(QuizzRepository::playQuizz($quizzId)['content'], true)['items'][$questionId];
        $duration = $question['duration'] ?? -1;

        //return $duration >= 1 ? $duration : $GLOBALS['DEFAULT_QUESTION_DURATION'];
        return $duration >= 1 ? $duration : config('global.DEFAULT_QUESTION_DURATION');
    }
}

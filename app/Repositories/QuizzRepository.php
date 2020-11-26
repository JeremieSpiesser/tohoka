<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Quizz;
use Illuminate\Support\Facades\Auth;

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
            $query->where('creator', Auth::id())
                  ->orWhere('private', '>=', (Auth::check() ? 1 : 2));
        })->firstOrFail();
    }
}

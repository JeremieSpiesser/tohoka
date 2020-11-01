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
        $userid = Auth::id();
        return Quizz::where('creator', '=', $userid)->get();
    }
}

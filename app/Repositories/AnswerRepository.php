<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Quizz;
use Illuminate\Support\Facades\Auth;

/**
 * Class AnswerRepository
 * @package App\Repositories
 */
class AnswerRepository
{
    public static function getPlayerAnswer($idInstance, $idPlayer){
        return Answers::select('answers')
            ->where('idInstance', $idInstance)
            ->where('idPlayer', $idPlayer)
            ->get();
    }

    public static function updateAnswer($idInstance, $idPlayer, $newAnswer){
        return Answers::update(['answers' => $newAnswer])
            ->where('idInstance', $idInstance)
            ->where('idPlayer', $idPlayer);
    }
}

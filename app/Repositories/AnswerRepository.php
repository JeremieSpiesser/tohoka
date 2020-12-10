<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->first()->answers;
    }

    public static function updateAnswer($idInstance, $idPlayer, $newAnswer){
        return DB::table('answers')
            ->where('idInstance', $idInstance)
            ->where('idPlayer', $idPlayer)
            ->update(['answers' => $newAnswer]);
    }
}

<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Quizz;
use App\Models\Instance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class InstanceRepository
 * @package App\Repositories
 */
class InstanceRepository
{
    public static function idIsUnused($id){
        return is_null(Instance::where('id', $id)->first());
    }

    public static function instanceIsLaunched($id){
        $instance = Instance::where('id', $id)->first();
        return is_null($instance) ? -1 : ($instance->currentQuestion != 0);
    }

    public static function getQuizzId($id){
        return Instance::select('idQuizz')
            ->where('id', $id)
            ->first()->idQuizz;
    }

    public static function getCurrentQuestion($id){
        return DB::table('instances')
            ->select('currentQuestion')
            ->where('id', $id)
            ->first()->currentQuestion;
    }

    public static function checkInstanceOwner($idInstance, $idUser){
        return DB::table('instances')
            ->select('master')
            ->where('id', $idInstance)
            ->first()->master === $idUser;
    }

    public static function blockAnswers($id){
        $question = InstanceRepository::getCurrentQuestion($id);

        return Instance::where('id', $id)
            ->update(['currentQuestion' => -1-$question]) == 1;
    }

    public static function openNextQuestion($id){
        $question = InstanceRepository::getCurrentQuestion($id);

        return Instance::where('id', $id)
            ->update(['currentQuestion' => -$question]) == 1;
    }

    public static function getNextQuestionDuration($id){
        $question = -InstanceRepository::getCurrentQuestion($id);

        return QuizzRepository::getQuestionDuration(InstanceRepository::getQuizzId($id), $question);
    }


    public static function canAcceptAnswer($instanceId, $questionId){
        $currentQuestion = InstanceRepository::getCurrentQuestion($instanceId);

        if ($questionId+1 != $currentQuestion)
            return false;
        return true;
    }
}

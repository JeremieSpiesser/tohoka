<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Quizz;
use App\Models\Instance;
use Illuminate\Support\Facades\Auth;

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
        return is_null($instance) ? -1 : ($instance->currentQuestion > -1);
    }

    public static function getQuizzId($id){
        return Instance::select('idQuizz')
            ->where('id', $id)
            ->first()->idQuizz;
    }
}

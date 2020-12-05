<?php

namespace App\Http\Controllers;


use App\Repositories\QuizzRepository;
use App\Repositories\InstanceRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Instance;
use Illuminate\Http\Request;

class InstanceAPIController extends Controller
{
    public function createInstance(Request $request){
        $instance = new Instance();

        try{
            QuizzRepository::playQuizz(Auth::id());
        }
        catch (Illuminate\Database\Eloquent\ModelNotFoundException $e){
            echo $e->msg;
            die();
        }

        do{
            $id = rand(0, 999999);
        } while (!InstanceRepository::idIsUnused($id));

        $instance->master = Auth::id();
        $instance->idQuizz = $request->get('idQuizz');
        $instance->id = $id;

        $instance->save();

        return $id;
    }

    public function launchInstance(Request $request){
        $state = InstanceRepository::instanceIsLaunched($request->post('id'));
        switch($state){
        case -1:
            return "Instance doesn't exist";
            break;
        case true:
            return "Instance already launched";
            break;
        case false:
            break;
        default:
            return "Unknown error";
        }

        return Instance::where('id', $request->post('id'))
            ->update(['currentQuestion' => -1])
            ->count() == 1;
    }

    public function joinInstance(){
        return view('joinInstance');
    }
}

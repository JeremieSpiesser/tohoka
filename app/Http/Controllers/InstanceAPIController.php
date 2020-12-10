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

        QuizzRepository::playQuizz(Auth::id());

        do{
            $id = rand(1000, 999999);
        } while (!InstanceRepository::idIsUnused($id));

        $instance->master = Auth::id();
        $instance->idQuizz = $request->get('idQuizz');
        $instance->id = $id;
        $instance->questionCount = QuizzRepository::getQuestionCount($request->get('idQuizz'));

        $instance->save();

        return view('manageInstance', ['id' => $id, 'master' => $instance->master, 'num' => $instance->questionCount]);
    }

    public function launchInstance(Request $request){
        $state = InstanceRepository::instanceIsLaunched($request->post('id'));
        switch($state){
        case -1:
            return response()->json(['message' => "Instance does not exist..."], 403);
            break;
        case true:
            return response()->json(['message' => "Instance already launched"], 403);
            break;
        case false:
            break;
        default:
            return response()->json(['message' => "Unknown error..."], 403);
        }

        return Instance::where('id', $request->post('id'))
            ->update(['currentQuestion' => -1])
            ->count() == 1;
    }

    public function joinInstance(){
        return view('joinInstance');
    }

    public function openNextQuestion(Request $req){
        $id = $req->post('idInstance');

        if (!InstanceRepository::checkInstanceOwner($id, Auth::id()))
            return response()->json(['message' => "Unauthorized"], 403);

        return InstanceRepository::openNextQuestion($id);
    }
}

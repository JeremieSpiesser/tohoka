<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\InstanceRepository;
use App\Repositories\AnswerRepository;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnswersAPIController extends Controller
{
    public function registerToInstance(Request $request){
        DB::table('answers')
            ->updateOrInsert(
                ['idInstance' => $request->post('idInstance'), 'idPlayer' => Auth::id()],
                ['answers' => '{}']
            );

        return QuizzsUIController::playquizz(InstanceRepository::getQuizzId($request->post('idInstance')), $request->post('idInstance'));
    }

    public function registerAnswer(Request $request){

        $instanceId = $request->post('idInstance');
        $questionId = $request->post('questionId');

        if (!InstanceRepository::canAcceptAnswer($instanceId, $questionId))
            return response()->json(['message' => 'You can\'t respond to this question right now!'], 403);

        $answer = DB::table('answers')
            ->select('answers')
            ->where('idInstance', $instanceId)
            ->where('idPlayer', Auth::id())
            ->first()
            ->answers;

        $array = json_decode($answer, true);
        $array[$questionId] = json_decode($request->post('answer'), true);

        $answer = json_encode($array);
        AnswerRepository::updateAnswer($instanceId, Auth::id(), $answer);
    }
}

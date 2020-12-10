<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class UploadController extends Controller
{
    public function handleUpload(Request $request)
    {
        if ($request->post('typeUpload') == 0){
            $validator = Validator::make($request->all(), [
                'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
            ]);
        }
        else {
            $validator = Validator::make($request->all(), [
                'audio' => 'required|mimes:audio/mpeg,mpga,mp3,wav'
            ]);
        }
        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->messages()
            ],400);
        };
        $uploadFolder = Auth::id() ;
        if ($request->post('typeUpload') == 0){
            $file = $request->file('image');
        }
        else{
            $file = $request->file('audio');
        }
        $file_uploaded_path = $file->store($uploadFolder, 'public');
        return response()->json([
            'id' => $uploadFolder,
            'filename' => basename($file_uploaded_path),
            'status' => 200,
        ], 200);
    }
}

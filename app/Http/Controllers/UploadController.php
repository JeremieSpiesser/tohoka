<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class UploadController extends Controller
{
    public function handleUpload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "error" => $validator->messages()
            ],400);
        };
        $uploadFolder = Auth::id() ;
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        return response()->json([
            'filename' => basename($image_uploaded_path),
            'status' => 200,
        ], 200);
    }
}

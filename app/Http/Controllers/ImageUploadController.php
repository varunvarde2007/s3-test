<?php

namespace App\Http\Controllers;

use App\Models\Image;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    //

    public function store(Request $request)
    {

        if (!$request->has(["url", "name"])) {
            return \response()->json(["status" => false, "message" => "Invalid Parameters"], 400);
        }
        $data = $request->all(["url", "name"]);
        $contents = Http::get($data["url"])->body();
        $extension = pathinfo($data["url"], PATHINFO_EXTENSION);
        $fileName = Str::random(32) . ".$extension";
        $status = Storage::disk("s3")->put("images/$fileName", $contents);
        if ($status) {
            $image = new Image();
            $image->name = $data["name"];
            $image->original_link = $data["url"];
            $image->s3_path = env("AWS_BUCKET") . "images/$fileName";
            $image->save();
            return response()->json(["status" => true, "message" => "Image Uploaded Successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "There was an issue uploading the file. Please try again"], 400);
        }
    }

    public function list()
    {
        $allFiles = Storage::disk("s3")->allFiles();
        return response()->json(["images" => $allFiles]);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function storeImage(Request $request)
    {
        if ($request->hasFile("upload")) {
            $originName = $request->file("upload")->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file("upload")->getClientOriginalExtension();
            $fileName = $fileName . "_" . time() . "." . $extension;

            $request
                ->file("upload")
                ->move(public_path("images/upload_images"), $fileName);

            $url = asset("media/" . $fileName);
            return response()->json([
                "fileName" => $fileName,
                "uploaded" => 1,
                "url" => $url,
            ]);
        }
    }
}

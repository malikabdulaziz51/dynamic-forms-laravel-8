<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Galeri';
        $gallery = \App\Models\Gallery::findOrFail($id);
        return view('pages.admin.dropzone-view', compact('title', 'gallery'));
    }


    public function upload(Request $request, $galleryId)
    {
        $image = $request->file('file');
        $fileInfo = $image->getClientOriginalName();
        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $imageName = $filename . '-' . time() . '.' . $extension;
        $gallery = \App\Models\Gallery::findOrFail($galleryId);
        $galleryName = Str::slug($gallery->name);
        $path = "images/gallery/" . $galleryName . "/";

        Storage::disk("public")->put(
            $path . $imageName,
            (string) file_get_contents($image)
        );


        $saveImage = Photo::create([
            "name" => $imageName,
            "id_gallery" => $galleryId
        ]);

        if ($saveImage) {
            return redirect()
                ->back()
                ->with([
                    "successMessage",
                    "Media Berhasil Di Tambahkan",
                ]);
        }
    }

    public function fetch($galleryId)
    {
        $gallery = \App\Models\Gallery::findOrFail($galleryId);
        $galleryName = Str::slug($gallery->name);
        $directory = 'images/gallery/' . $galleryName;
        $images = Storage::disk('public')->allFiles($directory);
        $output = '<div class="row">';
        foreach ($images as $image) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            if ($extension == "png" || $extension == "jpg" || $extension == "jpeg" || $extension == "gif") {
                $output .= '
                <div class="col-md-4" style="margin-bottom:16px;" align="center">
                        <div>
                        <a href="' . asset('storage/images/gallery/' . $galleryName . "/" . basename($image)) . '" data-toggle="lightbox">
                            <img src="' . asset('storage/images/gallery/' . $galleryName . "/" . basename($image)) . '" class="img-fluid" width="auto" style="height:250px;" />
                        </a>
                        </div>
                        <button type="button" class="btn btn-link remove_image" id="' . basename($image) . '">Remove</button>
                    </div>';
            } else if ($extension == "mp4") {
                $output .= '
                <div class="col-md-4" style="margin-bottom:16px;" align="center">
                        <div class="embed-responsive embed-responsive-16by9" style="height:250px;">
                        <video  class="img-fluid" controls>
                            <source src="' . asset('storage/images/gallery/' . $galleryName . "/" . basename($image)) . '">
                        </source>
                        </div>
                        <button type="button" class="btn btn-link remove_image" id="' . basename($image) . '">Remove</button>
                    </div>';
            }
        }
        $output .= '</div>';
        echo $output;
    }

    function delete(Request $request, $galleryId)
    {
        $gallery = \App\Models\Gallery::findOrFail($galleryId);
        $galleryName = Str::slug($gallery->name);
        $path = "images/gallery/" . $galleryName . "/";
        $image = $request->get('name');
        $check = Storage::disk("public")->exists($path . $image);
        // dd($check);
        $getImage = Photo::where('name', $image)->firstOrFail();
        if ($check) {
            Storage::disk('public')->delete($path . $image);
            $getImage->delete();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\Tag;
use App\Models\Category;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    }

    public function addBerita()
    {
        $title = "Berita";
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();
        return view("pages.admin.add-berita", compact("title", "tags", "categories"));
    }

    public function createBerita(Request $request)
    {
        $requestData = $request->only([
            "post_title",
            "thumbnail",
            "post_category",
            "post_content",
            "tags",
        ]);

        // dd($requestData);

        $validation = Validator::make($requestData, [
            "post_title" => "required|unique:master_berita,judul",
            "thumbnail" => "required|mimes:png,jpg,jpeg|max:5120",
            "post_category" => "required|exists:categories,id",
            "post_content" => "required",
            "tags" => "required",
        ]);
        // dd($validation->passes());

        if ($validation->passes()) {
            if ($request->hasFile("thumbnail")) {
                $path = "images/post_images/";
                $file = $request->file("thumbnail");
                $filename = $file->getClientOriginalName();
                $new_filename = time() . "_" . $filename;

                $upload = Storage::disk("public")->put(
                    $path . $new_filename,
                    (string) file_get_contents($file)
                );

                $post_thumbnails_path = $path . "thumbnails";
                if (!Storage::disk("public")->exists($post_thumbnails_path)) {
                    Storage::disk("public")->makeDirectory(
                        $post_thumbnails_path,
                        0755,
                        true,
                        true
                    );
                }

                // Create square thumbnail
                Image::make(storage_path("app/public/" . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(
                        storage_path(
                            "app/public/" .
                                $path .
                                "thumbnails/" .
                                "thumb_" .
                                $new_filename
                        )
                    );

                $createberita = \App\Models\Berita::create([
                    "author_id" => auth()->id(),
                    "category_id" => $request["post_category"],
                    "judul" => $request["post_title"],
                    "slug" => Str::slug($request["post_title"]),
                    "konten" => $request["post_content"],
                    "thumbnail" => $new_filename,
                ])
                    ->tag()
                    ->attach($request->tags);
                return redirect()
                    ->route("admin.berita")
                    ->with([
                        "successMessage" => "Berita Berhasil Di Tambahkan",
                    ]);
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation);
        }
        return redirect()
            ->back()
            ->withInput()
            ->withErrors($validation)
            ->with(["errorMessage" => "Data Invalid"]);
    }

    public function editBerita($id)
    {
        $title = "Edit Berita";
        $berita = Berita::findOrFail($id);
        $tags = Tag::all();
        $categories = Category::all();
        return view(
            "pages.admin.edit-berita",
            compact("title", "berita", "tags", "categories")
        );
    }

    public function updateBerita(Request $request, $id)
    {
        if ($request->hasFile("thumbnail")) {
            $request->validate([
                "post_title" => "required",
                "post_content" => "required",
                "post_category" => "required|exists:categories,id",
                "thumbnail" => "mimes:jpeg,jpg,png|max:5120",
                "tags" => "required",
            ]);
            $path = "images/post_images/";
            $file = $request->file("thumbnail");
            $filename = $file->getClientOriginalName();
            $new_filename = time() . "_" . $filename;

            $upload = Storage::disk("public")->put(
                $path . $new_filename,
                (string) file_get_contents($file)
            );

            $post_thumbnails_path = $path . "thumbnails";
            if (!Storage::disk("public")->exists($post_thumbnails_path)) {
                Storage::disk("public")->makeDirectory(
                    $post_thumbnails_path,
                    0755,
                    true,
                    true
                );
            }

            Image::make(storage_path("app/public/" . $path . $new_filename))
                ->fit(200, 200)
                ->save(
                    storage_path(
                        "app/public/" .
                            $path .
                            "thumbnails/" .
                            "thumb_" .
                            $new_filename
                    )
                );

            if ($upload) {
                $old_post_image = Berita::find($id)->thumbnail;

                if (
                    $old_post_image != null &&
                    Storage::disk("public")->exists($path . $old_post_image)
                ) {
                    Storage::disk("public")->delete($path . $old_post_image);

                    if (
                        Storage::disk("public")->exists(
                            $path . "thumbnails/thumb_" . $old_post_image
                        )
                    ) {
                        Storage::disk("public")->delete(
                            $path . "thumbnails/thumb_" . $old_post_image
                        );
                    }
                }
                $data = [
                    "category_id" => $request["post_category"],
                    "judul" => $request["post_title"],
                    "slug" => Str::slug($request["post_title"]),
                    "konten" => $request["post_content"],
                    "thumbnail" => $new_filename,
                ];
                $post = Berita::find($id);
                $update = $post->update($data);
                $post->tag()->sync($request->tags);

                if ($update) {
                    return redirect()
                        ->route("admin.berita")
                        ->with([
                            "successMessage" => "Berhasil Memperbarui Berita",
                        ]);
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validation);
                }
            } else {
                return redirect()
                    ->back()
                    ->with([
                        "errorMessage" => "Gagal Mengupload Thumbnail",
                    ]);
            }
        } else {
            $request->validate([
                "post_title" => "required",
                "post_content" => "required",
                "post_category" => "required|exists:categories,id",
                "tags" => "required",
            ]);

            $post = Berita::find($id);
            $update = $post->update([
                "category_id" => $request["post_category"],
                "judul" => $request["post_title"],
                "slug" => Str::slug($request["post_title"]),
                "konten" => $request["post_content"],
            ]);
            $post->tag()->sync($request->tags);
            if ($update) {
                return redirect()
                    ->route("admin.berita")
                    ->with([
                        "successMessage" => "Berhasil Memperbarui Berita",
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation);
            }
        }
    }
}

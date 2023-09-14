<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "teachers";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addTeacher()
    {
        $title = "Tambah Guru";
        return view("pages.admin.add-teacher", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTeacher(Request $request)
    {
        $requestData = $request->only([
            "teacher_name",
            "photo",
            "teacher_position"
        ]);

        $validation = Validator::make($requestData, [
            "teacher_name" => "required",
            "photo" => "required|mimes:png,jpg,jpeg|max:5120",
            "teacher_position" => "required"
        ]);
        if ($validation->passes()) {
            if ($request->hasFile("photo")) {
                $path = "images/teachers/";
                $file = $request->file("photo");
                $filename = $file->getClientOriginalName();
                $new_filename = time() . "_" . $filename;

                $upload = Storage::disk("public")->put(
                    $path . $new_filename,
                    (string) file_get_contents($file)
                );

                $teachers_photos_path = $path . "photos";
                if (!Storage::disk("public")->exists($teachers_photos_path)) {
                    Storage::disk("public")->makeDirectory(
                        $teachers_photos_path,
                        0755,
                        true,
                        true
                    );
                }

                // Create square photo
                Image::make(storage_path("app/public/" . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(
                        storage_path(
                            "app/public/" .
                                $path .
                                "photos/" .
                                "thumb_" .
                                $new_filename
                        )
                    );

                \App\Models\Teacher::create([
                    "name" => $request["teacher_name"],
                    "position" => $request["teacher_position"],
                    "photo" => $new_filename,
                ]);
                return redirect()
                    ->route("admin.teachers")
                    ->with([
                        "successMessage" => "Guru/Staff Berhasil Di Tambahkan",
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTeacher($id)
    {
        $title = "Edit Guru/Staff";
        $teacher = Teacher::findOrFail($id);
        return view(
            "pages.admin.edit-teacher",
            compact("title", "teacher")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTeacher(Request $request, $id)
    {
        if ($request->hasFile("photo")) {
            $requestData = $request->only([
                "teacher_name",
                "photo",
                "teacher_position"
            ]);

            $validation = Validator::make($requestData, [
                "teacher_name" => "required",
                "photo" => "required|mimes:png,jpg,jpeg|max:5120",
                "teacher_position" => "required"
            ]);

            if ($validation->passes()) {
                $path = "images/teachers/";
                $file = $request->file("photo");
                $filename = $file->getClientOriginalName();
                $new_filename = time() . "_" . $filename;

                $upload = Storage::disk("public")->put(
                    $path . $new_filename,
                    (string) file_get_contents($file)
                );

                $teachers_photos_path = $path . "photos";
                if (!Storage::disk("public")->exists($teachers_photos_path)) {
                    Storage::disk("public")->makeDirectory(
                        $teachers_photos_path,
                        0755,
                        true,
                        true
                    );
                }

                // Create square photo
                Image::make(storage_path("app/public/" . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(
                        storage_path(
                            "app/public/" .
                                $path .
                                "photos/" .
                                "thumb_" .
                                $new_filename
                        )
                    );

                if ($upload) {
                    $old_teacher_image = Teacher::find($id)->photo;

                    if (
                        $old_teacher_image != null &&
                        Storage::disk("public")->exists($path . $old_teacher_image)
                    ) {
                        Storage::disk("public")->delete($path . $old_teacher_image);

                        if (
                            Storage::disk("public")->exists(
                                $path . "photos/thumb_" . $old_teacher_image
                            )
                        ) {
                            Storage::disk("public")->delete(
                                $path . "photos/thumb_" . $old_teacher_image
                            );
                        }
                    }
                    $data = [
                        "name" => $request["teacher_name"],
                        "position" => $request["teacher_position"],
                        "photo" => $new_filename,
                    ];
                    $teacher = Teacher::find($id);
                    $update = $teacher->update($data);

                    if ($update) {
                        return redirect()
                            ->route("admin.teachers")
                            ->with([
                                "successMessage" => "Berhasil Memperbarui Data Guru/Staff",
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
                            "errorMessage" => "Gagal Mengupload Foto",
                        ]);
                }
            }
        } else {
            $requestData = $request->only([
                "teacher_name",
                "teacher_position"
            ]);

            $validation = Validator::make($requestData, [
                "teacher_name" => "required",
                "teacher_position" => "required"
            ]);

            $teacher = Teacher::find($id);
            $update = $teacher->update([
                "name" => $request["teacher_name"],
                "position" => $request["teacher_position"],
            ]);
            if ($update) {
                return redirect()
                    ->route("admin.teachers")
                    ->with([
                        "successMessage" => "Berhasil Memperbarui Data Guru/Staff",
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation);
            }
        }
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

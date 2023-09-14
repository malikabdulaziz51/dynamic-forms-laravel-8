<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function index()
    {
        $title = "Website Settings";
        $settings = Setting::first();
        return view('pages.admin.settings', compact('title', 'settings'));
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            "logo",
            "address",
            "email",
            "phone",
            "phone2",
            "instagram",
            "youtube",
        ]);
        // dd($requestData);

        $validation = Validator::make($requestData, [
            "email" => "email",
            "phone" => "numeric",
            "phone2" => "numeric",
        ]);
        // dd($request->hasFile('logo'));
        if ($validation->passes()) {
            if ($request->hasFile("logo")) {
                $path = "images/logos/";
                $file = $request->file("logo");
                $filename = time() . '_' . $file->getClientOriginalName();
                $new_filename = $filename;

                $logos_path = $path;
                if (!Storage::disk("public")->exists($logos_path)) {
                    Storage::disk("public")->makeDirectory(
                        $logos_path,
                        0755,
                        true,
                        true
                    );
                }

                $setting = Setting::first();
                if ($setting != null) {
                    $store = $setting->update([
                        "logo" => $new_filename,
                        "address" => $request["address"],
                        "email" => $request["email"],
                        "phone" => $request["phone"],
                        "phone2" => $request["phone2"],
                        "instagram" => $request["instagram"],
                        "youtube" => $request["youtube"],
                    ]);
                } else {
                    $store = Setting::create([
                        "logo" => $new_filename,
                        "address" => $request["address"],
                        "email" => $request["email"],
                        "phone" => $request["phone"],
                        "phone2" => $request["phone2"],
                        "instagram" => $request["instagram"],
                        "youtube" => $request["youtube"],
                    ]);
                }

                if ($store) {
                    $file_logo = Storage::disk('public')->allFiles($path);
                    // dd(!empty($file_logo));
                    if (empty($file_logo)) {
                        Storage::disk("public")->put(
                            $path . $new_filename,
                            (string) file_get_contents($file)
                        );
                    } else {
                        Storage::disk("public")->deleteDirectory($path);
                        Storage::disk("public")->put(
                            $path . $new_filename,
                            (string) file_get_contents($file)
                        );
                        // dd('there');
                    }
                    return redirect()
                        ->route("admin.information.settings")
                        ->with([
                            "successMessage" => "Berhasil Memperbarui Data",
                        ]);
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validation);
                }
            } else {
                $setting = Setting::first();
                if ($setting != null) {
                    $store = $setting->update([
                        "address" => $request["address"],
                        "email" => $request["email"],
                        "phone" => $request["phone"],
                        "phone2" => $request["phone2"],
                        "instagram" => $request["instagram"],
                        "youtube" => $request["youtube"],
                    ]);
                } else {
                    $store = Setting::create([
                        "address" => $request["address"],
                        "email" => $request["email"],
                        "phone" => $request["phone"],
                        "phone2" => $request["phone2"],
                        "instagram" => $request["instagram"],
                        "youtube" => $request["youtube"],
                    ]);
                }

                if ($store) {
                    return redirect()
                        ->route("admin.information.settings")
                        ->with([
                            "successMessage" => "Berhasil Memperbarui Data",
                        ]);
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validation);
                }
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation);
        }
    }
}

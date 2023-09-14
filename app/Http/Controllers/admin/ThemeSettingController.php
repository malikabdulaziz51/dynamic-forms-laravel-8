<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Facade\FlareClient\View;
use Illuminate\Http\Request;

class ThemeSettingController extends Controller
{

    public function index()
    {
    }

    public function updateTheme(Request $request)
    {
        $validatedData = $request->validate([
            'theme_id' => 'required|exists:themes,id'
        ]);

        Theme::where('active', true)->update(['active' => false]);

        $theme = Theme::findOrFail($validatedData['theme_id']);
        $theme->active = true;
        $update = $theme->save();

        if ($update) {
            return redirect()
                ->route("admin.theme.settings")
                ->with([
                    "successMessage" => "Update Theme Successfully",
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation);
        }
    }
}

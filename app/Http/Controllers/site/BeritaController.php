<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Setting;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BeritaController extends Controller
{
    public function index()
    {
        $theme = Theme::where('active', true)->first();
        View::share('activeTheme', $theme);
        $settings = Setting::first();
        return view('pages.site.list-berita', compact('settings'));
    }

    public function detail($id)
    {
        $berita = Berita::findOrFail($id);
        $theme = Theme::where('active', true)->first();
        View::share('activeTheme', $theme);
        $settings = Setting::first();
        return view('pages.site.detai-berita', compact('settings', 'berita'));
    }
}

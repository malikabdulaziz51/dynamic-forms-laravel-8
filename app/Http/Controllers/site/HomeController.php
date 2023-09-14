<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use \Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $theme = Theme::where('active', true)->first();
        View::share('activeTheme', $theme);
        $settings = Setting::first();
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        $news = Berita::orderBy('updated_at', 'desc')->take(3)->get();
        $teachers = Teacher::where('position', '1')->take(4)->get();
        return view('pages.site.home', compact('settings', 'news', 'teachers'));
    }
}

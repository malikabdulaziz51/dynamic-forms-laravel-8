<?php

namespace App\Http\Livewire\Admin;

use App\Models\Theme;
use Livewire\Component;

class ThemeSetting extends Component
{
    public function render()
    {
        return view('livewire.admin.theme-setting', [
            "themes" => Theme::all(),
            "activeTheme" => Theme::where('active', true)->first(),
            "title" => "Tema Website",
        ]);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class PPDBController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}

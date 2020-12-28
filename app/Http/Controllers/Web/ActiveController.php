<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;

class ActiveController extends Controller
{
    public function index()
    {
        return view("backend.pages.active.index");
    }

    public function query()
    {
    }
}

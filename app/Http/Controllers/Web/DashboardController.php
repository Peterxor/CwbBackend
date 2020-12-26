<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view("backend.pages.dashboard.index");
    }

    public function query()
    {
    }

    public function edit()
    {
        return view('backend.pages.dashboard.edit');
    }

    public function update()
    {
    }

    public function probe()
    {
        return 'ok';
    }
}

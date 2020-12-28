<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Device;

class DashboardController extends Controller
{
    public function index()
    {
        $devices = Device::with(['user'])->get();
//        dd($devices->toArray());

        return view("backend.pages.dashboard.index", compact('devices'));
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

    public function updateDeviceHost()
    {

    }
}

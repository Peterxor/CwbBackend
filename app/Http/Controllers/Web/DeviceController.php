<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;

class DeviceController extends Controller
{
    public function index()
    {
        // todo https://pl70hd.axshare.com/#id=1f8vbf&p=a_1_%E8%A3%9D%E7%BD%AE%E6%8E%92%E7%89%88%E7%AE%A1%E7%90%86
        return view("backend.pages.device.index");
    }

    public function info()
    {
        //todo https://pl70hd.axshare.com/#id=r1l380&p=a_1_1_%E5%9C%96%E8%B3%87%E9%A0%85%E7%9B%AE%E6%8E%92%E7%89%88%E8%A8%AD%E5%AE%9A
        return view('backend.pages.device.info');
    }
}

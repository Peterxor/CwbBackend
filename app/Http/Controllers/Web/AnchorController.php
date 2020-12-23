<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;

class AnchorController extends Controller
{
    public function index()
    {
        // todo https://pl70hd.axshare.com/#id=h9u7bh&p=b_2_%E5%9C%96%E8%B3%87%E7%AE%A1%E7%90%86-%E5%A4%A9%E6%B0%A3
        return view("backend.pages.anchor.index");
    }


    public function edit()
    {
        // todo https://pl70hd.axshare.com/#id=vue7xr&p=e_1_1_%E5%80%8B%E5%88%A5%E6%8E%92%E7%89%88%E5%81%8F%E5%A5%BD%E8%A8%AD%E5%AE%9A&g=1

        return view('backend.pages.anchor.edit');

    }

    public function update()
    {
    }
}

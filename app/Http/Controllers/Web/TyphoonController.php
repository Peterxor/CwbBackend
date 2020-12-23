<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use Illuminate\Support\Facades\Request;

class TyphoonController extends Controller
{
    public function index()
    {
        // todo https://pl70hd.axshare.com/#id=vaom2b&p=b_1_%E5%9C%96%E8%B3%87%E7%AE%A1%E7%90%86-%E9%A2%B1%E9%A2%A8
        return view("backend.pages.typhoon.index");
    }

    public function updateOrder()
    {

    }

    public function edit(Request $request)
    {
        //todo https://pl70hd.axshare.com/#id=agddx6&p=b_1_1_%E9%A2%B1%E9%A2%A8%E5%8B%95%E6%85%8B
        $sort = 1;

        return view('backend.pages.typhoon.edit', compact('sort'));
    }


    public function update()
    {
    }
}

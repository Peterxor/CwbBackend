<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PersonnelController extends Controller
{
    public function index()
    {
        return view("backend.pages.personnel.index");
    }

    public function query(): \Illuminate\Http\JsonResponse
    {
    }

    public function create()
    {
        return view("backend.pages.personnel.create");
    }

    public function store(RoleRequest $request)
    {
    }

    public function edit($id)
    {
        return view("backend.pages.personnel.edit");
    }

    public function update($id, Request $request)
    {
    }
}

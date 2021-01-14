<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Personnel;
use App\Http\Requests\PersonnelRequest;

class PersonnelController extends Controller
{
    public function index()
    {

        return view("backend.pages.personnel.index");
    }

    public function query(): \Illuminate\Http\JsonResponse
    {
        $query = Personnel::orderBy('created_at', 'DESC');
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'nick_name' => $item->nick_name,
                'career' => $item->career,
            ];
        })->toJson();
    }

    public function create()
    {
        return view("backend.pages.personnel.create");
    }

    public function store(PersonnelRequest $request)
    {
        $exps = $this->checkExp($request->exp);
        $create = [
            'name' => $request->name ?? '',
            'nick_name' => $request->nick_name ?? '',
            'career' => $request->career ?? '',
            'education' => $request->education ?? '',
            'experience' => json_encode($exps ?? [])
        ];

        Personnel::create($create);
        return redirect(route('personnel.index'));
    }

    public function edit($id)
    {
        $person = Personnel::find($id);
        $experience = $person->experience;
        return view("backend.pages.personnel.edit", compact('person', 'experience'));
    }

    public function update(PersonnelRequest $request, $id)
    {
        $exps = $this->checkExp($request->exp);
        $update = [
            'name' => $request->name ?? '',
            'nick_name' => $request->nick_name ?? '',
            'career' => $request->career ?? '',
            'education' => $request->education ?? '',
            'experience' => json_encode($exps ?? [])
        ];

        Personnel::where('id', $id)->update($update);
        return redirect(route('personnel.index'));

    }

    public function checkExp($experience)
    {
        $temp = $experience;
        $exps = [];
        foreach ($temp as $e) {
            if ($e) {
                $exps[] = $e;
            }
        }
        return $exps;
    }
}

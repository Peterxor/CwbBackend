<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Personnel;
use App\Http\Requests\PersonnelRequest;

class PersonnelController extends Controller
{
    /**
     * 人員間接管理
     * @return Application|Factory|View
     */
    public function index()
    {
        if (!hasPermission('view_personnel')) {
            abort(403);
        }
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

    /**
     * 新增人員
     * @return Application|Factory|View
     */
    public function create()
    {
        if (!hasPermission('add_personnel')) {
            abort(403);
        }
        return view("backend.pages.personnel.create");
    }

    /**
     * 儲存人員
     * @param PersonnelRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(PersonnelRequest $request)
    {
        if (!hasPermission('add_personnel')) {
            abort(403);
        }
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

    /**
     * 編輯人員
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        if (!hasPermission('edit_personnel')) {
            abort(403);
        }
        $person = Personnel::find($id);
        $experience = $person->experience;
        return view("backend.pages.personnel.edit", compact('person', 'experience'));
    }

    /**
     * 更新人員
     * @param PersonnelRequest $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(PersonnelRequest $request, $id)
    {
        if (!hasPermission('edit_personnel')) {
            abort(403);
        }
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

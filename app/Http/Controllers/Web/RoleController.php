<?php

namespace App\Http\Controllers\Web;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RoleRequest;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        //
        return view('backend.pages.role.index');

    }

    public function query()
    {
        $query = Role::where('guard_name', 'web')->orderBy('created_at');

        $query->when(request()->get('name', false), function ($query) {
            $query->where('name', 'like', '%'.request()->get('name').'%');
        });

        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return [
                'id'=>$item->id,
                'name'=>$item->name,
                'guard_name' => $item->guard_name,
                'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y/m/d H:i:s') : '',
                'updated_at'=>$item->updated_at ? Carbon::parse($item->updated_at)->format('Y/m/d H:i:s') : ''
            ];
        })->toJson();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        //
        $permissions = Permission::all();
        return view('backend.pages.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(RoleRequest $request)
    {
        //
        try {
            $this->validate($request, [
                'name' => 'required|unique:member_roles',
                'permissions' => 'array'
            ]);
            $role = Role::create($request->only('name'));
            $role->syncPermissions($request->permissions);
        } catch (Exception $e) {
            Log::error('Role Controller store error: ' . $e->getMessage());
        }
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        //
        $role = Role::find($id);
        $permissions = Permission::all();
        $rolePermission = $role->getPermissionNames()->toArray();
        return view('backend.pages.role.edit', compact('role', 'permissions', 'rolePermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(RoleRequest $request, $id)
    {
        //
        try {
            if($role = Role::findOrFail($id)) {
                // admin role has everything
                if($role->name === 'Admin') {
                    $role->syncPermissions(Permission::all());
                } else {
                    $role->name = $request->name;
                    $role->save();
                    $permissions = $request->permissions ?? [];
                    $role->syncPermissions($permissions);
                }
            }
        } catch (Exception $e) {
            Log::error('role update error: ' . $e->getMessage());
        }
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        //
        try {
            if ($role = Role::findOrFail($id)) {
                if ($role->name === 'Admin') {
                    throw new Exception('無法刪除Admin角色');
                }
                $role->delete();
            }
        } catch (Exception $e) {
            Log::error('role delete error: '. $e->getMessage());
            return $this->sendError('刪除失敗');
        }
        return $this->sendResponse('', '刪除成功');
    }
}

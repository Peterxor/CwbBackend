<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Models\Role;
use Egulias\EmailValidator\Exception\ExpectingQPair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('backend.pages.user.index', compact('roles'));
    }

    public function query()
    {
        $query = User::orderBy('created_at');

        $query->when(request()->get('name', false), function ($query) {
            $query->where('name', 'like', '%'.request()->get('name').'%');
        })->when(request()->get('role', false), function ($query) {
            $query->role(request()->get('role'));
        });

        return DataTables::eloquent($query)->setTransformer(function ($item) {
            // foreach ($item->getAllPermissions() as $permission) {
            //     $permissions[] = $permission->name;
            // }
            return [
                'id' => $item->id,
                'email' => $item->email,
                'name'=>$item->name,
                'role_name'=>$item->getRoleNames(),
                'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y/m/d H:i:s') : '',
                'updated_at'=>$item->updated_at ? Carbon::parse($item->updated_at)->format('Y/m/d H:i:s') : ''
            ];
        })->toJson();
    }

    public function create()
    {
        $roles = Role::all();
        return view('backend.pages.user.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        // hash password
        $request->merge(['password' => Hash::make($request->get('password'))]);
        $user = $request->except('role');

        if ($user = User::create($user)) {
            $user->roles()->sync([$request->input('role')]);
        }

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRoles = $user->getRoleNames()->toArray();

        return view('backend.pages.user.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->fill($request->except('role', 'permissions', 'password'));

            // check for password change
            if ($request->get('password')) {
                $user->password = Hash::make($request->get('password'));
            }

            $user->roles()->sync([$request->input('role')]);
            $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return;
        }

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        try {
            if (Auth::user()->id == $id) {
                throw new \Exception('無法刪除自己');
            }
            User::findOrFail($id)->delete();
        } catch (\Exception $e) {
            Log::error(Auth::user()->name . '刪除' . $id . '失敗： ' . $e->getMessage());
            return $this->sendError('刪除失敗');
        }
        return $this->sendResponse('', '刪除成功');
    }

    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if (! $user->hasAllRoles($roles)) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);
        return $user;
    }
}

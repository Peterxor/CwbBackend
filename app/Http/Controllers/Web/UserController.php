<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\PermissionException;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * 使用者管理
     *
     * @return View
     */
    public function index(): View
    {
        if (!hasPermission('view_users')) {
            abort(403);
        }
        $roles = Role::all();
        return view('backend.pages.user.index', compact('roles'));
    }

    /**
     * 查詢使用者
     *
     * @return JsonResponse
     */
    public function query(): JsonResponse
    {
        $query = User::query();

        $query->when(request()->get('name', false), function ($query) {
            $query->where('name', 'like', '%' . request()->get('name') . '%');
        })->when(request()->get('role', false), function ($query) {
            $query->role(request()->get('role'));
        });

        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'email' => $item->email,
                'name' => $item->name,
                'role_name' => $item->getRoleNames(),
                'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y/m/d H:i:s') : '',
                'updated_at' => $item->updated_at ? Carbon::parse($item->updated_at)->format('Y/m/d H:i:s') : ''
            ];
        })->toJson();
    }

    /**
     * 新增使用者UI
     *
     * @return View
     */
    public function create(): View
    {
        if (!hasPermission('add_users')) {
            abort(403);
        }
        $roles = Role::all();
        return view('backend.pages.user.create', compact('roles'));
    }

    /**
     * 新增使用者
     *
     * @param UserRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request)
    {
        if (!hasPermission('add_users')) {
            abort(403);
        }
        // hash password
        $request->merge(['password' => Hash::make($request->get('password'))]);
        $input = $request->all();

        /** @var User $user */
        if ($user = User::query()->create($input)) {
            $user->roles()->sync([$request->get('role')]);
            $item = '新增使用者[' . ($user->name ?? '') . ']';
            activity()
                ->performedOn($user)
                ->causedBy(Auth::user()->id)
                ->withProperties([
                    'ip' => request()->getClientIp(),
                    'item' => $item,
                ])
                ->log('新增');
        }

        return redirect()->route('users.index');
    }

    /**
     * 編輯使用者UI
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        if (!hasPermission('edit_users')) {
            abort(403);
        }
        $roles = Role::all();
        $userRoles = $user->getRoleNames()->toArray();

        return view('backend.pages.user.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * 更新使用者資訊
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        if (!hasPermission('edit_users')) {
            abort(403);
        }
        try {
            $user->fill($request->except('role', 'permissions', 'password'));

            // check for password change
            if ($request->get('password')) {
                $user->password = Hash::make($request->get('password'));
            }

            $user->roles()->sync([$request->get('role')]);
            $user->save();
            $item = '更新使用者[' . ($user->name ?? '') . ']';
            activity()
                ->performedOn($user)
                ->causedBy(Auth::user()->id)
                ->withProperties([
                    'ip' => request()->getClientIp(),
                    'item' => $item,
                ])
                ->log('修改');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('users.index');
    }

    /**
     * 刪除使用者
     *
     * @param User $user
     * @return JsonResponse
     * @throws PermissionException
     */
    public function destroy(User $user): JsonResponse
    {
        if (!hasPermission('delete_users')) {
            throw new PermissionException();
        }
        /** @var User $auth */
        $auth = Auth::user();
        if ($auth->id == $user->id) {
            return $this->sendError('無法刪除自己');
        }
        try {
            $userName = $user->name ?? '';
            $item = '刪除使用者[' . $userName . ']';
            activity()
                ->causedBy(Auth::user()->id)
                ->withProperties([
                    'ip' => request()->getClientIp(),
                    'item' => $item,
                ])
                ->log('刪除');
            $user->delete();
        } catch (Exception $e) {
            Log::error($auth->name . '刪除' . $user->id . '失敗： ' . $e->getMessage());
            return $this->sendError('刪除失敗');
        }
        return $this->sendResponse('', '刪除成功');
    }
}

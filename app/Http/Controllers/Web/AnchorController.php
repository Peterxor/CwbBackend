<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Device;
use App\Models\GeneralImages;
use App\Models\HostPreference;
use App\Models\TyphoonImage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class AnchorController extends Controller
{
    /**
     * 主播偏好
     *
     * @return View
     */
    public function index(): View
    {
        if (!hasPermission('view_anchor')) {
            abort(403);
        }
        return view("backend.pages.anchor.index");
    }

    /**
     * 查詢主播偏好
     *
     * @return JsonResponse
     */
    public function query(): JsonResponse
    {
        $device = Device::all();
        if (Auth::user()->hasRole('Admin')) {
            $query = User::query()->whereHas('roles', function ($query){
                $query->where('name', 'User');
            });
        } else {
            $query = User::query()->where('email', Auth::user()->email);
        }


        return DataTables::eloquent($query)->setTransformer(function ($item) use($device) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'device_id_1' => $device->where('name', '防災視訊室')->first()->id,
                'device_id_2' => $device->where('name', '公關室')->first()->id,
            ];
        })->toJson();
    }

    /**
     * 編輯主播偏好
     *
     * @param $id
     * @param $device_id
     * @return View
     */
    public function edit($id, $device_id):View
    {
        if (!hasPermission('edit_anchor')) {
            abort(403);
        }
        $hostPreference = HostPreference::query()->with(['user', 'device'])->firstOrCreate([
            'user_id' => $id,
            'device_id' => $device_id
        ]);

        return view('backend.pages.anchor.edit', compact('hostPreference'));
    }


    /**
     * 更新主播偏好
     *
     * @param Request $request
     * @param HostPreference $hostPreference
     * @return RedirectResponse
     */
    public function update(Request $request, HostPreference $hostPreference): RedirectResponse
    {
        if (!hasPermission('edit_anchor')) {
            abort(403);
        }
        $key = $request->get('key');
        $beforeJson = $hostPreference->preference_json;
        $itemKeys = [];
        foreach ($request->get('preference', []) as $itemKey => $item){
//            $hostPreference->preference_json[$key][$itemKey] = $item;
            $itemKeys[] = $itemKey;
            $tempPreferenceJson = $hostPreference->preference_json;
            $tempPreferenceJson[$key][$itemKey] = $item;
            $hostPreference->preference_json = $tempPreferenceJson;
        }
        $hostPreference->save();
        $item = '更新主播偏好[' . ($hostPreference->user->name ?? '') .']-[' . ($hostPreference->device->name ?? '') . ']:';
        savePreferenceLog($key, $hostPreference, $itemKeys, $request, $beforeJson, $item);
        return redirect()->back();
    }
}

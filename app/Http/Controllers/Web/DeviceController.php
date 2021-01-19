<?php

namespace App\Http\Controllers\Web;

use App\Models\Device;
use App\Http\Controllers\Web\Controller as Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    /**
     * 裝置排版管理
     *
     * @return View
     */
    public function index(): View
    {
        if (!hasPermission('view_device')) {
            abort(403);
        }
        return view("backend.pages.device.index");
    }

    /**
     * 查詢裝置排版
     *
     * @return JsonResponse
     */
    public function query(): JsonResponse
    {
        $query = Device::query();

        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        })->toJson();
    }

    /**
     * 編輯裝置排版
     *
     * @param Device $device
     * @return View
     */
    public function edit(Device $device): View
    {
        if (!hasPermission('edit_device')) {
            abort(403);
        }
        $name = $device->name;
        $preference = $device->preference_json;

        return view('backend.pages.device.edit', compact( 'device','name', 'preference'));
    }


    /**
     * 更新裝置排版
     *
     * @param Request $request
     * @param Device $device
     * @return RedirectResponse
     */
    public function update(Request $request, Device $device): RedirectResponse
    {
        if (!hasPermission('edit_device')) {
            abort(403);
        }
        $key = $request->get('key');
        $beforeJson = $device->preference_json;
        $itemKeys = [];
        foreach ($request->get('preference', []) as $itemKey => $item) {
            $itemKeys[] = $itemKey;
            $tempPreferenceJson = $device->preference_json;
            $tempPreferenceJson[$key][$itemKey] = $item;
            $device->preference_json = $tempPreferenceJson;
        }
        $device->save();
        $item = '更新裝置[' . ($device->name ?? '') . ']元件座標：';
        savePreferenceLog($key, $device, $itemKeys, $request, $beforeJson, $item);

        return redirect()->back();
    }
}

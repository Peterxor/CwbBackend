<?php

namespace App\Http\Controllers\Web;
use App\Models\Device;
use App\Http\Controllers\Web\Controller as Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    public function index()
    {
        return view("backend.pages.device.index");
    }

    public function query(): \Illuminate\Http\JsonResponse
    {
        $query = Device::query();

        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        })->toJson();
    }

    public function edit($id)
    {
        $device = Device::query()->find($id);
        $name = $device->name;
        $preference = $device->preference_json;

        return view('backend.pages.device.edit', compact('id', 'name', 'preference'));
    }


    public function update($id, Request $request)
    {
        $key = $request->get('key');
        $device = Device::query()->find($id);
        $preference = $device->preference_json;

        foreach ($request->get('preference', []) as $itemKey => $item){
                $preference[$key][$itemKey] = $item;
        }

        $device->preference_json = $preference;
        $device->save();

        return redirect()->back();
    }
}

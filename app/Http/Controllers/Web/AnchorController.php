<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Device;
use App\Models\HostPreference;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnchorController extends Controller
{
    public function index()
    {
        return view("backend.pages.anchor.index");
    }

    public function query()
    {
        $device = Device::all();

        $query = User::query()->whereHas('roles', function ($query){
            $query->where('name', 'User');
        });

        return DataTables::eloquent($query)->setTransformer(function ($item) use($device) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'device_id_1' => $device->where('name', '防災視訊室')->first()->id,
                'device_id_2' => $device->where('name', '公關室')->first()->id,
            ];
        })->toJson();
    }

    public function edit($id, $device_id)
    {
        $hostPreference = HostPreference::query()->with(['user', 'device'])->firstOrCreate([
            'user_id' => $id,
            'device_id' => $device_id
        ]);

        return view('backend.pages.anchor.edit', compact('hostPreference'));
    }


    public function update($id, Request $request)
    {
        $key = $request->get('key');
        $device = HostPreference::query()->find($id);
        $preference = $device->preference_json;

        foreach ($request->get('preference', []) as $itemKey => $item){
            $preference[$key][$itemKey] = $item;
        }

        $device->preference_json = $preference;
        $device->save();

        return redirect()->back();
    }
}

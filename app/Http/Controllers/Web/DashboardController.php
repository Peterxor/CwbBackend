<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\TyphoonImage;
use App\Models\GeneralImages;

class DashboardController extends Controller
{
    public function index()
    {
        $devices = Device::with(['user'])->get();
//        dd($devices->toArray());

        return view("backend.pages.dashboard.index", compact('devices'));
    }


    public function edit(Request $request, $id)
    {
        $pic_type = $request->pic_type ?? 'typhoon';
        $query = Device::where('id', $id)->first();
        $data = $pic_type === 'typhoon' ? $query->typhoon_json : $query->forecast_json;
        $images = [];
        if ($pic_type === 'typhoon') {
            $images = TyphoonImage::get();
        } else {
            $images = GeneralImages::get();
        }
        $data = json_decode($data);
        $loop_times = 10;
//        dd($data);

        return view('backend.pages.dashboard.edit', compact('id', 'pic_type', 'data', 'loop_times', 'images'));
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $origin_ids = $request->origin_img_id;
        $image_types = $request->image_type;
        $upload_ids = $request->img_id;
        $upload_name = $request->img_name;
        $upload_url = $request->img_url;
        $json_type = $request->pic_type;
        $db_origin_img = [];
        if ($json_type == 'typhoon') {
            $typhoons = TyphoonImage::get();
            foreach ($typhoons as $t) {
                $db_origin_img[$t->id] = $t->name;
            }
        } else {
            $generals = GeneralImages::get();
            foreach ($generals as $g) {
                $db_origin_img[$g->id] = $g->name;
            }
        }

        $datas = [];

        foreach ($image_types as $index => $type) {
            $temp = $type == 'origin' ? [
                'type' => $type,
                'img_id' => $origin_ids[$index],
                'img_name' => $db_origin_img[$origin_ids[$index]],
            ] : [
                'type' => $type,
                'img_id' => $upload_ids[$index],
                'img_name' => $upload_name[$index],
                'img_url' => $upload_url[$index]
            ];
            $datas[] = $temp;
        }

        $json_data = json_encode($datas);
        $update = $json_type == 'typhoon' ? ['typhoon_json' => $json_data] : ['forecast_json' => $json_data];

        Device::where('id', $id)->update($update);
        return redirect(route('dashboard.index'));


    }

    public function probe()
    {
        return 'ok';
    }

    public function updateDeviceHost(Request $request)
    {
        Device::where('id', $request->device_id)->update(['user_id' => $request->user_id]);

        return $this->sendResponse('', 'success');
    }
}

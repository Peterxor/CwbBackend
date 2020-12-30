<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Device;
use Illuminate\Http\JsonResponse;

class AnchorInformationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $device = Device::where('id', 1)->first();
        $typhoon = json_decode($device->typhoon_json);
        $data = [];
        foreach ($typhoon as $index => $value) {
            $data[] = [
                'title' => $value->img_name,
                'image' => env('APP_URL') . $value->img_url,
            ];
        }
        return response()->json($data);
    }
}

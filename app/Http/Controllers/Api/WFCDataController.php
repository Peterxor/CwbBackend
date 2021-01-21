<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\Board;
use App\Models\Device;
use App\Models\TyphoonImage;
use App\Services\WFC\AnchorInformation;
use App\Services\WFC\Dashboard;
use App\Services\WFC\Exceptions\WFCException;
use App\Services\WFC\RainfallForecast;
use App\Services\WFC\RainfallObservation;
use App\Services\WFC\TyphoonDynamics;
use App\Services\WFC\TyphoonPotential;
use App\Services\WFC\WeatherInformation;
use App\Services\WFC\WeatherOverview;
use App\Services\WFC\WindForecast;
use App\Services\WFC\WindObservation;
use Illuminate\Http\JsonResponse;

class WFCDataController extends Controller
{
    /**
     * @param Device $device 裝置
     * @return JsonResponse
     * @throws WFCException
     */
    public function index(Device $device): JsonResponse
    {
        $preference = preference($device);

        $typhoonImages = TyphoonImage::all(['name', 'content']);

        $board = Board::query()->with(['media', 'personnel_a', 'personnel_b'])->where('device_id', $device->id)->first()->toArray();

        $data = [
            'meta' => [
                'theme' => $device->theme_url,
                'color' => $preference['tool']['colors'] ?? []
            ],
            'dashboard' => Dashboard::get($board, $preference),
            'typhoon' => [
                'information' => AnchorInformation::get($device->typhoon_json, $preference),
                'typhoon-dynamics' => TyphoonDynamics::get($typhoonImages->where('name', 'typhoon-dynamics')->first()->content, $preference),
                'typhoon-potential' => TyphoonPotential::get($typhoonImages->where('name', 'typhoon-potential')->first()->content, $preference),
                'wind-observation' => WindObservation::get($typhoonImages->where('name', 'wind-observation')->first()->content, $preference),
                'wind-forecast' => WindForecast::get($typhoonImages->where('name', 'wind-forecast')->first()->content, $preference),
                'rainfall-observation' => RainfallObservation::get($typhoonImages->where('name', 'rainfall-observation')->first()->content, $preference),
                'rainfall-forecast' => RainfallForecast::get($typhoonImages->where('name', 'rainfall-forecast')->first()->content, $preference),
            ],
            'weather' => [
                'slider' => WeatherInformation::get($device->forecast_json, $preference),
                'overview' => WeatherOverview::get($preference)
            ]
        ];

        $data['preload_images'] = $this->preloadImages($data);

        return response()->json($data);
    }

    private function preloadImages(array $data): array
    {
        $images = [];

        foreach ($data['meta']['theme'] ?? [] as $theme){
            $images[] = $theme;
        }

        if($data['dashboard']['data']['type'] == 'default')
            $images[] = $data['dashboard']['data']['background'];
        else
            $images[] = $data['dashboard']['data']['media_url'];

        $imageList = $data['typhoon']['information']['information'] ?? [];

        array_push($imageList,
            $data['typhoon']['typhoon-dynamics']['ir'],
            $data['typhoon']['typhoon-dynamics']['mb'],
            $data['typhoon']['typhoon-dynamics']['vis'],
            $data['typhoon']['rainfall-observation']['rainfall']['today'],
            $data['typhoon']['rainfall-observation']['rainfall']['before1nd'],
            $data['typhoon']['rainfall-observation']['rainfall']['before2nd'],
            $data['typhoon']['rainfall-observation']['rainfall']['before3nd'],
            $data['typhoon']['rainfall-observation']['rainfall']['before4nd']
        );

        $imageList = array_merge_recursive($imageList, $data['weather']['information']['information'] ?? []);

        foreach ($imageList as $information){
            if(array_key_exists('image_l', $information)){
                $images[] = $information['image_l'];
            }
            if(array_key_exists('image_r', $information)){
                $images[] = $information['image_r'];
            }
            if(array_key_exists('image', $information)){
                $images[] = $information['image'];
            }
            if(array_key_exists('thumbnail', $information)){
                $images[] = $information['thumbnail'];
            }
            if(array_key_exists('images', $information)){
                foreach ($information['images'] as $image){
                    $images[] = $image;
                }
            }
        }
        return array_values(array_unique($images));
    }
}

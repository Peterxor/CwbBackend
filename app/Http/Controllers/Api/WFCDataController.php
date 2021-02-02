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
use App\Services\WFC\WeatherSlider;
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

        $hostPreference = $device->hostPreference()->where('user_id', $device->user_id)->first();
        $typhoon_json = $hostPreference->typhoon_json ?? $device->typhoon_json;
        $forecast_json = $hostPreference->forecast_json ?? $device->forecast_json;

        $typhoonImages = TyphoonImage::all(['name', 'content']);

        $board = Board::query()->with(['media', 'personnel_a', 'personnel_b'])->where('device_id', $device->id)->first()->toArray();

        $data = [
            'meta' => [
                'theme' => $device->theme_url,
                'color' => $preference['tool']['colors'] ?? []
            ],
            'dashboard' => Dashboard::get($board, $preference),
            'typhoon' => [
                'information' => AnchorInformation::get($typhoon_json, $preference),
                'typhoon_dynamics' => TyphoonDynamics::get($typhoonImages->where('name', 'typhoon_dynamics')->first()->content, $preference),
                'typhoon_potential' => TyphoonPotential::get($typhoonImages->where('name', 'typhoon_potential')->first()->content, $preference),
                'wind_observation' => WindObservation::get($typhoonImages->where('name', 'wind_observation')->first()->content, $preference),
                'wind_forecast' => WindForecast::get($typhoonImages->where('name', 'wind_forecast')->first()->content, $preference),
                'rainfall_observation' => RainfallObservation::get($typhoonImages->where('name', 'rainfall_observation')->first()->content, $preference),
                'rainfall_forecast' => RainfallForecast::get($typhoonImages->where('name', 'rainfall_forecast')->first()->content, $preference),
            ],
            'weather' => [
                'slider' => WeatherSlider::get($forecast_json, $preference),
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
            $data['typhoon']['typhoon_dynamics']['ir'],
            $data['typhoon']['typhoon_dynamics']['mb'],
            $data['typhoon']['typhoon_dynamics']['vis'],
            $data['typhoon']['rainfall_observation']['rainfall']['today'],
            $data['typhoon']['rainfall_observation']['rainfall']['before1nd'],
            $data['typhoon']['rainfall_observation']['rainfall']['before2nd'],
            $data['typhoon']['rainfall_observation']['rainfall']['before3nd'],
            $data['typhoon']['rainfall_observation']['rainfall']['before4nd']
        );

        $imageList = array_merge_recursive($imageList, $data['weather']['slider']['information'] ?? []);
        $imageList = array_merge_recursive($imageList, $data['weather']['overview']['information'] ?? []);

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

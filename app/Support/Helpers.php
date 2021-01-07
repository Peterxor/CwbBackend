<?php

use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Device;
use App\Models\HostPreference;

if (!function_exists('getBackground')) {
    function getBackground($background)
    {
        switch ($background) {
            default:
            case 0:
                return [
                    [
                        'name' => '雲朵版',
                        'value' => 1,
                    ],
                    [
                        'name' => '彩虹版',
                        'value' => 2,
                    ]
                ];
            case 1:
                return '雲朵版';
            case 2:
                return '彩虹版';
        }
    }
}

if (!function_exists('getTheme')) {
    function getTheme($theme)
    {
        switch ($theme) {
            case 0:
                return [
                    [
                        'name' => '自然',
                        'value' => 1,
                    ],
                    [
                        'name' => '科技藍',
                        'value' => 2,
                    ],
                    [
                        'name' => '工業橘',
                        'value' => 3,
                    ],
                    [
                        'name' => '現代紅',
                        'value' => 4,
                    ]
                ];
            default:
            case 1:
                return '自然';
            case 2:
                return '科技藍';
            case 3:
                return '工業橘';
            case 4:
                return '現代紅';
        }
    }
}

if (!function_exists('uploadMedia')) {
    function uploadMedia($file) {
        $filesystem = 'media';
        if (env('MEDIA_TYPE', 'media') == 's3') {
            $filesystem = 's3';
        }
        DB::beginTransaction();
        $extension = $file->getClientOriginalExtension();
        $origin_name = $file->getClientOriginalName();
        $name = Str::replaceLast('.' . $extension, '', $origin_name);
        $file_name = $name . '.' . $extension;
        $path = '/cwb';

        $new_media = new Media([
            'disk' => $filesystem,
            'file_name' => $name,
            'mime_type' => $extension,
            'path' => $path . '/' . $file_name,
            'size' => $file->getSize(),
        ]);
        $new_media->save();
        if (env('MEDIA_TYPE', 'media') == 's3') {
            $s3_path = Storage::disk($filesystem)->put($path . '/' . $file_name, file_get_contents($file));
            Log::info('save to s3: '. $s3_path);
        } else {
            $file->storeAs($path, $file_name, $filesystem);
        }

        DB::commit();
        return [
            'new_media' => $new_media,
            'filesystem' => $filesystem,
            'path' => $path,
            'file_name' => $file_name,
        ];
    }
}

if (!function_exists('preference')) {
    function preference(Device $device): array
    {
        /** @var HostPreference $hostPreference */
        $hostPreference = HostPreference::query()->firstOrCreate(['user_id' => $device->user_id, 'device_id' => $device->id]);

        return array_merge($device->preference_json, $hostPreference->preference_json ?? []);
    }
}

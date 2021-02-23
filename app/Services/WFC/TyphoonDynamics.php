<?php

namespace App\Services\WFC;

use App\Services\WFC\Exceptions\WFCException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class TyphoonDynamics
{
    /**
     * 颱風動態
     *
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array
     * @throws WFCException
     */
    static public function get(array $setting, array $preference): array
    {
        $titlePreference = $preference['typhoon']['typhoon_dynamics']['title'];
        $toolMiddlePreference = $preference['typhoon']['typhoon_dynamics']['tool_middle'];

        return [
            'meta' => [
                'title' => [
                    'scale' => $titlePreference['scale'] ?? 100,
                    'point_x' => $titlePreference['point_x'] ?? 0,
                    'point_y' => $titlePreference['point_y'] ?? 0,
                ],
                'tool_middle' => [
                    'scale' => $toolMiddlePreference['scale'] ?? 100,
                    'point_x' => $toolMiddlePreference['point_x'] ?? 0,
                    'point_y' => $toolMiddlePreference['point_y'] ?? 0,
                ]
            ],
            'typhoon' => self::typhoonFormat(Storage::disk('data')->path($setting['typhoon_dynamics']['origin'] ?? '')),
            'ir' => self::imageFormat('颱風IR', $setting['typhoon_ir'] ?? [], $preference['typhoon']['typhoon_dynamics']['typhoon_ir'] ?? []),
            'mb' => self::imageFormat('颱風MB', $setting['typhoon_mb'] ?? [], $preference['typhoon']['typhoon_dynamics']['typhoon_mr'] ?? []),
            'vis' => self::imageFormat('颱風VIS', $setting['typhoon_vis'] ?? [], $preference['typhoon']['typhoon_dynamics']['typhoon_vis'] ?? [])
        ];
    }

    /**
     * 颱風動勢格式
     *
     * @param string $path
     * @return array
     * @throws WFCException
     */
    static private function typhoonFormat(string $path): array
    {
        try {
            $typhoonDynamics = simplexml_load_file($path);

            $data = [
                'time' => Carbon::create((string)$typhoonDynamics->current->Point->Time)->toDateTimeLocalString() . '+08:00',
                'past' => [
                    'time' => (string)$typhoonDynamics->past->Point->Time,
                    'lat' => (float)$typhoonDynamics->past->Point->Lat,
                    'lon' => (float)$typhoonDynamics->past->Point->Lon
                ],
                'current' => [
                    'time' => (string)$typhoonDynamics->current->Point->Time,
                    'offset' => (int)$typhoonDynamics->current->Point->offset,
                    'lat' => (float)$typhoonDynamics->current->Point->Lat,
                    'lon' => (float)$typhoonDynamics->current->Point->Lon,
                    'intensity' => (int)$typhoonDynamics->current->Point->Intensity,
                    'radius' => (int)$typhoonDynamics->current->Point->Class7,
                ]
            ];

            $fcst = [];

            foreach ($typhoonDynamics->fcst->Point as $point) {
                $fcst[] = [
                    'time' => (string)$point->Time,
                    'label' => (string)$point->Label,
                    'offset' => (int)$point->offset,
                    'lat' => (float)$point->Lat,
                    'lon' => (float)$point->Lon,
                    'intensity' => (int)$point->Intensity,
                    'radius' => (int)$point->Class7,
                ];
            }

            $data['fcst'] = $fcst;

            $warning = ['sea' => [], 'land' => []];

            foreach ($typhoonDynamics->WarningAreaConfig->area as $area) {
                if ((string)$area->attributes()['name'] == 'sea') {
                    foreach ($area->blk as $blk) {
                        if ($blk->attributes()['st'] == 1) {
                            foreach ($blk->obj as $obj) {
                                if ($obj->attributes()['st'] == 1) {
                                    $warning['sea'][(string)$blk->attributes()['name']][] = (int)$obj->attributes()['id'];
                                }
                            }
                        }
                    }
                }

                if ((string)$area->attributes()['name'] == 'land') {
                    foreach ($area->blk as $blk) {
                        if ($blk->attributes()['st'] == 1) {
                            $warning['land'][(string)$blk->attributes()['name']] = 1;
                        }
                    }
                }
            }

            $data['warning'] = $warning;

            return $data;
        } catch (Exception $exception) {
            throw new WFCException('颱風動態資料解析錯誤', 500, $exception);
        }
    }

    /**
     * 颱風動態圖資顯示
     *
     * @param string $title 圖資標題
     * @param array $setting 圖資設定
     * @param array $preference 裝置設定
     * @return array|null
     * @throws WFCException
     */
    static private function imageFormat(string $title, array $setting, array $preference): array
    {
        if (!isset($setting['origin']))
            throw new WFCException('颱風動態[' . $title . ']資料解析錯誤', 500);

        try {
            $path = rtrim($setting['origin'] ?? '', '/');

            $files = array_reverse(iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($path))->sortByName(), false));

            $endTime = '';
            $startTime = '';

            $images = [];
            foreach ($files as $key => $file) {
                if ($key >= ($setting['amount'] ?? 1))
                    break;

                if ($key == 0) {
                    $endTime = $file->getBasename();
                }
                $startTime = $file->getBasename();
                $images[] = Storage::disk('data')->url($path . '/' . $file->getBasename());
            }

            $description = count($images) > 0 ?
                Carbon::createFromFormat('Y-m-d_Hi', substr($startTime, 0, 15))->format('m/d h:i')
                . ' ~ ' . Carbon::createFromFormat('Y-m-d_Hi', substr($endTime, 0, 15))->format('m/d h:i') : '';

            return [
                'mode' => 'gif',
                'scale' => $preference['scale'] ?? 100,
                'point_x' => $preference['point_x'] ?? 0,
                'point_y' => $preference['point_y'] ?? 0,
                'interval' => $setting['interval'] ?? 1000,
                'title' => $title,
                'description' => $description,
                'images' => array_reverse($images),
                'thumbnail' => count($images) > 0 ? $images[0] : null
            ];
        } catch (Exception $exception) {
            throw new WFCException('颱風動態[' . $title . ']資料解析錯誤', 500, $exception);
        }
    }
}

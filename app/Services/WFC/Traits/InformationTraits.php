<?php

namespace App\Services\WFC\Traits;

use App\Models\GeneralImages;
use App\Services\WFC\Exceptions\WFCException;
use Exception;

trait InformationTraits
{
    /**
     * 圖資格式整理
     *
     * @param string $title
     * @param array $setting
     * @param array $preference
     * @return array
     * @throws WFCException
     */
    static private function format(string $title,  array $setting, array $preference): array
    {
        try {
            $count = 1;
            $informationList = [];
            foreach ($setting as $settingImage) {
                $type = weatherType($settingImage['img_name']);

                /** @var GeneralImages $generalImage */
                $generalImage = GeneralImages::query()->where('name', $settingImage['img_name'])->first();
                $imagePreference = $preference['weather']['images'][$settingImage['img_name']];
                $information = [
                    'mode' => GeneralImages::$mode[$type],
                    'scale' => $imagePreference['scale'] ?? 100,
                    'point_x' => $imagePreference['point_x'] ?? 0,
                    'point_y' => $imagePreference['point_y'] ?? 0,
                    'title' => $generalImage->content['display_name'] ?? ('小叮嚀' . $count),
                    'description' => '11月30日 11:50 ~ 11月30日 12:00', // TODO: 時間欄位串接
                ];
                if ($settingImage['type'] == 'origin') {
                    switch ($type) {
                        case 1:
                            $image = imageUrl($setting['origin']);
                            $informationList[] = array_merge($information, [
                                'image' => $image,
                                'thumbnail' => $image
                            ]);
                            break;
                        case 2:
                            $images = imagesUrl($setting['origin'], $setting['amount']);
                            $informationList[] = array_merge($information, [
                                'interval' => $generalImage->content['interval'],
                                'images' => $images,
                                'thumbnail' => $images[0]
                            ]);
                            break;
                        case 3:
                            $images = imagesUrl($setting['origin'], 6);
                            $informationList[] = array_merge($information, [
                                'images' => $images,
                                'thumbnail' => $images[0]
                            ]);
                            break;
                        case 4:
                            $leftImage = imageUrl($setting['origin_left']);
                            $rightImage = imageUrl($setting['origin_right']);
                            $informationList[] = array_merge($information, [
                                'image_l' => $leftImage,
                                'image_r' => $rightImage,
                                'thumbnail' => $rightImage
                            ]);
                            break;
                    }
                } else {
                    $informationList[] = array_merge($information, [
                        'image' => url($settingImage['img_url']),
                        'thumbnail' => url($settingImage['img_url'])
                    ]);

                    $count++;
                }
            }

            return $informationList;
        } catch (Exception $exception) {
            throw new WFCException($title . '資料解析錯誤', 500, $exception);
        }
    }
}

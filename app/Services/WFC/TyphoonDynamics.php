<?php

namespace App\Services\WFC;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;
use stdClass;
use Symfony\Component\Finder\Finder;

class TyphoonDynamics
{
    /**
     * 颱風動態
     *
     * @param stdClass $content 圖資內容
     * @param array $preference 個人設定
     * @return array
     */
    static public function get(stdClass $content, array $preference): array
    {
        // TODO: 需修改變數結構
        $content->show_info->ir->dispaly_name = '東亞IR';
        $content->show_info->mb->dispaly_name = '東亞MB';
        $content->show_info->vis->dispaly_name = '東亞VIS';
        return [
            'typhoon' => self::typhoonFormat(Storage::disk('data')->path($content->info->origin)),
            'ir' => self::imageFormat($content->show_info->ir),
            'mb' => self::imageFormat($content->show_info->mb),
            'vis' => self::imageFormat($content->show_info->vis)
        ];
    }

    static private function typhoonFormat(string $path): array
    {
        $typhoonDynamics = simplexml_load_file($path);

        $data = [
            'time' => (string)$typhoonDynamics->Information->IssueTime,
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
                'class7' => (int)$typhoonDynamics->current->Point->Class7,
            ]
        ];

        $fcst = [];

        foreach ($typhoonDynamics->fcst->Point as $point){
            $fcst[] = [
                'time' => (string)$point->Time,
                'label' => (string)$point->Label,
                'offset' => (int)$point->offset,
                'lat' => (float)$point->Lat,
                'lon' => (float)$point->Lon,
                'intensity' => (int)$point->Intensity,
                'class7' => (int)$point->Class7,
            ];
        }

        $data['fcst'] = $fcst;

        $warning = ['sea' => [], 'land' => []];

        foreach ($typhoonDynamics->WarningAreaConfig->area as $area) {
            foreach ($area->blk as $blk) {
                if ($blk->attributes()['st'] == 1) {
                    foreach ($blk->obj as $obj) {
                        if ($obj->attributes()['st'] == 1) {
                            $warning[(string)$area->attributes()['name']][(string)$blk->attributes()['name']][] = (int)$obj->attributes()['id'];
                        }
                    }
                }
            }
        }

        $data['warning'] = $warning;

        return $data;
    }

    static private function imageFormat($info): array
    {
        $path = rtrim($info->origin, '/');

        $files = array_reverse(iterator_to_array(Finder::create()->files()->in(Storage::disk('data')->path($path))->sortByName(), false));

        $endTime = '';
        $startTime = '';

        $images = [];
        foreach ($files as $key => $file) {
            if ($key >= $info->move_pages)
                break;

            if ($key == 0) {
                $endTime = $file->getBasename();
            }
            $startTime = $file->getBasename();
            $images[] = Storage::disk('data')->url($path . $file->getBasename());
        }

        $description = count($images) > 0 ?
            Carbon::createFromFormat('Y-m-d_Hi', substr($startTime, 0, 15))->format('m/d h:i')
            . ' ~ ' . Carbon::createFromFormat('Y-m-d_Hi', substr($endTime, 0, 15))->format('m/d h:i') : '';

        // TODO: 串接縮放參數
        return [
            'mode' => 'gif',
            'scale' => 150,
            'point_x' => 0,
            'point_y' => 0,
            'interval' => 1000,
            'title' => $info->dispaly_name,
            'description' => $description,
            'images' => array_reverse($images),
            'thumbnail' => count($images) > 0 ? $images[0] : null
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Finder\Finder;

class TyphoonDynamicsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $content = json_decode(TyphoonImage::query()->where('name', '颱風動態圖')->first()->content);

        return response()->json([
            'typhoon' => $this->typhoonFormat(storage_path($content->info->origin)),
            'ir' => $this->imageFormat($content->show_info->ir, 'typhoon/ir'),
            'mb' => $this->imageFormat($content->show_info->mb, 'typhoon/mb'),
            'vis' => $this->imageFormat($content->show_info->vis, 'typhoon/vis')
        ]);
    }

    private function typhoonFormat(string $path): array
    {
        $typhoonDynamics = simplexml_load_file($path);

        $data = [
            'time' => $typhoonDynamics->Information->IssueTime,
            'past' => $typhoonDynamics->past->Point,
            'current' => $typhoonDynamics->current->Point,
            'fcst' => $typhoonDynamics->fcst->Point
        ];

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

    private function imageFormat($info, $gifPath): array
    {
        $files = array_reverse(iterator_to_array(Finder::create()->files()->in(storage_path($info->origin))->sortByName(), false));
        $typhoonImages = [];
        foreach ($files as $key => $file) {
            if ($key >= $info->move_pages)
                continue;
            $typhoonImages[] = $file->getPathname();
        }

        shell_exec('convert -loop 1 -delay ' . (int)($info->change_rate_page * 1000) . ' ' . implode(' ', array_reverse($typhoonImages)) . ' ' . public_path($gifPath . '/output.gif'));

        return ['image' => url($gifPath . '/output.gif')];
    }
}

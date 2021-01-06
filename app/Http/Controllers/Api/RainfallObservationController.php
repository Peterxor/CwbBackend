<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Jobs\GenerateGifJob;
use App\Models\TyphoonImage;
use App\Services\WFC\Transformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Finder\Finder;

class RainfallObservationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $content = json_decode(TyphoonImage::query()->where('name', '雨量觀測')->first()->content);
        $pages = $content->info->move_pages;
        $second = $content->info->change_rate_second;
        $data = [
            'today' => $this->format($pages, $second, $content->timezone_rain->one_day_before->status, storage_path($content->info->origin_word), storage_path($content->info->origin_pic), 'images/rainfall/today'),
            'before1nd' => $this->format($pages, $second, $content->timezone_rain->one_day_before->status, storage_path($content->timezone_rain->one_day_before->word), storage_path($content->timezone_rain->one_day_before->pic), 'images/rainfall/before1nd'),
            'before2nd' => $this->format($pages, $second, $content->timezone_rain->two_day_before->status, storage_path($content->timezone_rain->two_day_before->word), storage_path($content->timezone_rain->two_day_before->pic), 'images/rainfall/before2nd'),
            'before3nd' => $this->format($pages, $second, $content->timezone_rain->three_day_before->status, storage_path($content->timezone_rain->three_day_before->word), storage_path($content->timezone_rain->three_day_before->pic), 'images/rainfall/before3nd'),
            'before4nd' => $this->format($pages, $second, $content->timezone_rain->four_day_before->status, storage_path($content->timezone_rain->four_day_before->word), storage_path($content->timezone_rain->four_day_before->pic), 'images/rainfall/before4nd'),
        ];
        return response()->json($data);
    }

    private function format($pages, $second, $status, string $txtPath, string $imagePath, string $gifPath): array
    {
        $data = ['enable' => $status, 'startTime' => '', 'endTime' => '', 'image' => '', 'top' => ['c' => [],'a' => [], 'n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []], 'location' => ['n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []]];

        /** 圖片處理 */
        // 以名稱排序(A-Z)取最後一個
        $files = array_reverse(iterator_to_array(Finder::create()->files()->in($imagePath)->sortByName(), false));
        $rainfallImages = [];
        foreach ($files as $key => $file) {
            if($key >= $pages)
                continue;
            $rainfallImages[] = $file->getPathname();
        }

        dispatch(new GenerateGifJob('convert -loop 1 -delay ' .(int)($second * 1000) .' ' .implode(' ', array_reverse($rainfallImages)) . ' ' .public_path($gifPath . '/output.gif')));

        $data['image'] = url($gifPath . '/output.gif');

        // 以名稱排序(A-Z)取最後一個
        $files = iterator_to_array(Finder::create()->files()->in($txtPath)->sortByName(), false);
        $rainfallTxt = fopen($files[count($files) - 1]->getPathname(), 'r');


        if (!feof($rainfallTxt))
            fgets($rainfallTxt);

        if (!feof($rainfallTxt)) {
            $str = $this->txtDecode(fgets($rainfallTxt));
            if (!empty($str)) {
                $strArr = explode(" ", $str);
                $data['startTime'] = Carbon::create($strArr[0] . ' ' . $strArr[1])->toDateTimeLocalString() . '+08:00';
                $data['endTime'] = Carbon::create($strArr[3] . ' ' . $strArr[4])->toDateTimeLocalString() . '+08:00';
            }
        }

        while (!feof($rainfallTxt)) {
            $str = $this->txtDecode(fgets($rainfallTxt));
            if (empty($str))
                continue;
            $strArr = explode(" ", $str);
            $area = Transformer::parseAddress($strArr[2]);

            if (count($data['top']['a']) < 5) {
                $data['top']['a'][] = [
                    'city' => $area[0],
                    'area' => $strArr[1],
                    'value' => (float)$strArr[0]
                ];
            }

            if (count($data['top'][Transformer::parseRainfallObsCity($area[0])]) < 5) {
                $data['top'][Transformer::parseRainfallObsCity($area[0])][] = [
                    'city' => $area[0],
                    'area' => $strArr[1],
                    'value' => (float)$strArr[0]
                ];
            }

            if (array_key_exists($area[0], $data['location'][Transformer::parseRainfallObsCity($area[0])])) {
                continue;
            }
            $data['location'][Transformer::parseRainfallObsCity($area[0])][$area[0]] = [
                'value' => (float)$strArr[0]
            ];

            if (count($data['top']['c']) < 5) {
                $data['top']['c'][] = [
                    'city' => $area[0],
                    'area' => $area[1],
                    'value' => (float)$strArr[0]
                ];
            }
        }

        fclose($rainfallTxt);

        return $data;
    }

    private function txtDecode(string $line): string
    {
        return trim(preg_replace("/\s(?=\s)/", "\\1",
            mb_convert_encoding($line, "UTF-8", "BIG5")));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class RainfallObservationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = [
            'today' => $this->format(storage_path('data/rainfall/obs/today/rainfallObs.txt')),
            'before1nd' => $this->format(storage_path('data/rainfall/obs/before1nd/rainfallObs.txt')),
            'before2nd' => $this->format(storage_path('data/rainfall/obs/before2nd/rainfallObs.txt')),
            'before3nd' => $this->format(storage_path('data/rainfall/obs/before3nd/rainfallObs.txt')),
            'before4nd' => $this->format(storage_path('data/rainfall/obs/before4nd/rainfallObs.txt')),
        ];

        return response()->json($data);
    }

    private function format(string $path): array
    {
        $rainfallObs = fopen($path, 'r');

        $data = ['image' => url('test/rainfall.gif')];

        if (!feof($rainfallObs))
            fgets($rainfallObs);

        if (!feof($rainfallObs)) {
            $str = $this->txtDecode(fgets($rainfallObs));
            if (!empty($str)){
                $strArr = explode(" ", $str);
                $data['startTime'] = Carbon::create($strArr[0] . ' ' . $strArr[1])->toDateTimeLocalString() . '+08:00';
                $data['endTime'] = Carbon::create($strArr[3] . ' ' . $strArr[4])->toDateTimeLocalString() . '+08:00';
            }
        }

        while (!feof($rainfallObs)) {
            $str = $this->txtDecode(fgets($rainfallObs));
            if (empty($str))
                continue;
            $strArr = explode(" ", $str);
            $data['location'][$strArr[2]] = [
                'value' => $strArr[0]
            ];
        }

        fclose($rainfallObs);

        return $data;
    }

    private function txtDecode(string $line): string
    {
        return trim(preg_replace("/\s(?=\s)/", "\\1",
            mb_convert_encoding($line, "UTF-8", "BIG5")));
    }
}

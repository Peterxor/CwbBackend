<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Models\TyphoonImage;
use Illuminate\Http\JsonResponse;

class TyphoonPotentialController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $content = json_decode(TyphoonImage::query()->where('name', '颱風潛勢圖')->first()->content);

        $typhoonPotential = simplexml_load_file(storage_path($content->info->origin));

        return response()->json($typhoonPotential);
    }
}

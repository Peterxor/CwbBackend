<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Services\WFC\WindForecast;
use Illuminate\Http\JsonResponse;

class WindForecastController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(WindForecast::get());
    }
}

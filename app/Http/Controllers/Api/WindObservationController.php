<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Services\WFC\WindObservation;
use Illuminate\Http\JsonResponse;

class WindObservationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(WindObservation::get());
    }
}

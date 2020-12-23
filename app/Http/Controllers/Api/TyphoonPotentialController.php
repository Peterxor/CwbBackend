<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;

class TyphoonPotentialController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json();
    }
}

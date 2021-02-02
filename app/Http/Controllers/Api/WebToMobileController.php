<?php

namespace App\Http\Controllers\Api;

use App\Events\MobileActionEvent;
use App\Events\WebActionEvent;
use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class WebToMobileController extends Controller
{
    /**
     * 網頁對平板的行動請求
     * @param Request $request
     * @return JsonResponse
     */
    public function sendPad(Request $request): JsonResponse
    {
        $room = $request->get('room', '');
        $screen = $request->get('screen', '');
        $sub = $request->get('sub', '');
        $behaviour = $request->get('behaviour', '');
        $res['success'] = true;
        $res['data'] = $request->all();
        broadcast(new WebActionEvent($room, $screen, $sub, $behaviour));
        return response()->json($res);
    }


}

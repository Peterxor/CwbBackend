<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Device;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\GeneralImages;
use App\Models\Personnel;
use App\Models\Board;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;
use App\Exceptions\PermissionException;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard
     *
     * @return Application|RedirectResponse|Redirector|View
     */
    public function index()
    {
        if (!Auth::user()->hasRole('Admin')) {
            return redirect(route('anchor.index'));
        }

        $devices = Device::with(['user', 'board' => function ($query) {
            $query->with(['media']);
        }])->get();
        $themes = getTheme(0);
        $backgrounds = getBackground(0);
        $personnel = Personnel::all();
        return view("backend.pages.dashboard.index", compact('devices', 'themes', 'personnel', 'backgrounds'));
    }

    /**
     * 編輯颱風主播圖卡或天氣預報排程
     *
     * @param Request $request
     * @param Device $device
     * @return View
     */
    public function edit(Request $request, Device $device): View
    {
        if (!hasPermission('edit_dashboard')) {
            abort(403);
        }
        $pic_type = $request->pic_type ?? 'typhoon';
        $data = $pic_type === 'typhoon' ? $device->typhoon_json : $device->forecast_json;
        $images = GeneralImages::all();
        $loop_times = 9;

        return view('backend.pages.dashboard.edit', compact('device', 'pic_type', 'data', 'loop_times', 'images'));
    }

    /**
     * 更新颱風主播圖卡或天氣預報排程
     *
     * @param Request $request
     * @param Device $device
     * @return RedirectResponse
     */
    public function update(Request $request, Device $device)
    {
        if (!hasPermission('edit_dashboard')) {
            abort(403);
        }
        $origin_ids = $request->get('origin_img_id');
        $image_types = $request->get('image_type');
        $upload_ids = $request->get('img_id');
        $upload_name = $request->get('img_name');
        $upload_url = $request->get('img_url');
        $json_type = $request->get('pic_type');
        $db_origin_img = [];
        $generals = GeneralImages::all();
        foreach ($generals as $g) {
            $db_origin_img[$g->id] = $g->name;
        }

        $data = [];

        foreach ($image_types as $index => $type) {
            if ($type === 'choose_not') {
                continue;
            }
            $temp = $type == 'origin' ? [
                'type' => $type,
                'img_id' => $origin_ids[$index],
                'img_name' => $db_origin_img[$origin_ids[$index]],
                'img_url' => getWeatherImage($db_origin_img[$origin_ids[$index]])
            ] : [
                'type' => $type,
                'img_id' => $upload_ids[$index],
                'img_name' => $upload_name[$index],
                'img_url' => $upload_url[$index]
            ];
            $data[] = $temp;
        }
        $update = $json_type == 'typhoon' ? ['typhoon_json' => $data] : ['forecast_json' => $data];
        $beforeJson = $json_type == 'typhoon' ? $device->typhoon_json : $device->forecast_json;
        $item = '更新[' . $device->name . ']' . ($json_type == 'typhoon' ? '颱風主播圖卡' : '天氣預報排程');

        $device->update($update);
        activity()
            ->performedOn($device)
            ->causedBy(Auth::user()->id)
            ->withProperties([
                'ip' => $request->getClientIp(),
                'item' => $item,
                'before_json' => $beforeJson,
            ])
            ->log('修改');
        return redirect(route('dashboard.index'));
    }

    /**
     * 更新主播
     * @param Request $request
     * @return JsonResponse
     * @throws PermissionException
     */
    public function updateDeviceHost(Request $request): JsonResponse
    {
        if (!hasPermission('edit_dashboard')) {
            throw new PermissionException();
        }
        $device = Device::query()->where('id', $request->get('device_id'))->first();
        $device->user_id = $request->get('user_id');
        $device->save();
        $item = '更新[' . $device->name . ']' . '主播：' . ($device->user->name ?? '不指定');
        activity()
            ->performedOn($device)
            ->causedBy(Auth::user()->id)
            ->withProperties([
                'ip' => $request->getClientIp(),
                'item' => $item,
            ])
            ->log('修改');

        return $this->sendResponse('', 'success');
    }

    /**
     * 更新佈景主題
     * @param Request $request
     * @return JsonResponse
     * @throws PermissionException
     */
    public function updateDeviceTheme(Request $request): JsonResponse
    {
        if (!hasPermission('edit_dashboard')) {
            throw new PermissionException();
        }
//        Device::query()->where('id', $request->get('device_id'))->update(['theme' => $request->get('theme')]);
        $device = Device::query()->where('id', $request->get('device_id'))->first();
        $device->theme = $request->get('theme');
        $device->save();
        $item = '更新[' . $device->name . ']' . '佈景主題：' . (getTheme($device->theme));
        activity()
            ->performedOn($device)
            ->causedBy(Auth::user()->id)
            ->withProperties([
                'ip' => $request->getClientIp(),
                'item' => $item,
            ])
            ->log('修改');
        return $this->sendResponse('', 'success');
    }

    /**
     * 更新看板
     * @param Request $request
     * @return JsonResponse
     * @throws PermissionException
     */
    public function updateBoard(Request $request): JsonResponse
    {
        if (!hasPermission('edit_dashboard')) {
            throw new PermissionException();
        }
        try {
            $board = Board::where('id', $request->board_id)->first();
            $board->type = $request->edition_type === 'default' ? 1 : 2;
            $board->device_id = $request->device_id ?? $board->device_id;
            $board->personnel_id_a = $request->people_1 ?? 0;
            $board->personnel_id_b = $request->people_2 ?? 0;
            $board->conference_time = $request->news_time ?? null;
            $board->conference_status = $request->news_status ?? 0;
            $board->next_conference_time = $request->next_news_time ?? null;
            $board->next_conference_status = $request->next_news_status ?? 0;
            $board->background = $request->board_background ?? 1;
            $board->media_id = null;
            if ($request->edition_type === 'upload') {
                $res = uploadMedia($request->file('file'));
                $board->media_id = $res['new_media']->id;
            }
            $board->save();
            $response = $board->toArray();
            $response['media_name'] = isset($res) ? $res['new_media']->file_name . '.' . $res['new_media']->mime_type : '';

            $item = '更新[' . $board->device->name . ']' . '看板';
            activity()
                ->performedOn($board)
                ->causedBy(Auth::user()->id)
                ->withProperties([
                    'ip' => $request->getClientIp(),
                    'item' => $item,
                ])
                ->log('修改');
            return $this->sendResponse($response, 'update success');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError($e->getMessage(), [], 400, '更新看板失敗');
        }
    }

    /**
     * keepalive
     *
     * @return string
     */
    public function probe(): string
    {
        return 'ok';
    }


    public function clearRedis()
    {
        Redis::del('menus');
        return 'ok';
    }
}

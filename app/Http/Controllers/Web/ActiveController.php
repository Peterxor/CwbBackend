<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller as Controller;
use App\Models\Active;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ActiveController extends Controller
{
    /**
     * 紀錄事件
     *
     * @return View
     */
    public function index(): View
    {
        return view("backend.pages.active.index");
    }

    /**
     * 查詢記錄事件
     *
     * @return JsonResponse
     */
    public function query(): JsonResponse
    {
        $query = Active::query();

        $query->when(request()->get('active_type', false), function ($query) {
            $query->where('description', 'like', '%' . request()->get('active_type') . '%');
        })->when(request()->get('start_date', false), function ($query) {
            $query->where('created_at', '>=', request()->get('start_date'));
        })->when(request()->get('end_date', false), function ($query) {
            $query->where('created_at', '<=', request()->get('end_date') . ' 23:59:59');
        });

        return DataTables::eloquent($query)->setTransformer(function ($item) {
            $properties = (array)json_decode($item->properties);

            return [
                'id' => $item->id,
                'date' => Carbon::parse($item->created_at)->format('Y/m/d H:i:s'),
                'active' => $item->description,
                'user' => $item->user->name,
                'item' => '',
                'ip' => $properties['ip'] ?? '',
            ];
        })->toJson();
    }
}

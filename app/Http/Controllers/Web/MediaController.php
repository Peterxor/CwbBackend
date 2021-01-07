<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        try {
            $res = uploadMedia($request->file('file'));

            return $this->sendResponse([
                "image_id" => $res['new_media']->id,
                "url" => Storage::disk($res['filesystem'])->url($res['path'] . '/' . $res['file_name']),
                'name' => $res['file_name']
            ], 'upload image success');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return $this->sendError($e->getMessage(), []);
        }
    }
}

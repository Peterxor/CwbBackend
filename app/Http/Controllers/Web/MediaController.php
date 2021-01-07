<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as Controller;
use Exception;
use Illuminate\Support\Str;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    /** @var string */
    private $filesystem = 'media';

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        try {
            if (env('MEDIA_TYPE', 'media') == 's3') {
                $this->filesystem = 's3';
            }

            DB::beginTransaction();

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $origin_name = $file->getClientOriginalName();
            $name = Str::replaceLast('.' . $extension, '', $origin_name);
            $file_name = $name . '.' . $extension;
            $path = '/cwb';

            $new_media = new Media([
                'disk' => $this->filesystem,
                'file_name' => $name,
                'mime_type' => $extension,
                'path' => $path . '/' . $file_name,
                'size' => $file->getSize(),
            ]);

            $new_media->save();
            if (env('MEDIA_TYPE', 'media') == 's3') {
                $s3_path = Storage::disk($this->filesystem)->put($path . '/' . $file_name, file_get_contents($file));
                Log::info('save to s3: '. $s3_path);
            } else {
                $file->storeAs($path, $file_name, $this->filesystem);
            }

            DB::commit();


            return $this->sendResponse([
                "image_id" => $new_media->id,
                "url" => Storage::disk($this->filesystem)->url($path . '/' . $file_name),
                'name' => $file_name
            ], 'upload image success');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return $this->sendError($e->getMessage(), []);
        }
    }
}

<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponserTraits
{
    /**
     * return response.
     *
     * @param $result
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    protected function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @param string $productionError
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 400, $productionError = '伺服器錯誤'): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => config('app.debug') ? $error : $productionError,
        ];

        if (!empty($errorMessages) && config('app.debug')) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}

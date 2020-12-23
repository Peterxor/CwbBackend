<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponserTraits{


    protected function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message
        ];


        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 400, $productionError = 'Unexpected Error')
    {
        $response = [
            'success' => false,
            'message' => config('app.debug') ? $error : $productionError,
        ];

        if(!empty($errorMessages) && config('app.debug')){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

}

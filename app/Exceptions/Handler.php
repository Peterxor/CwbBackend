<?php

namespace App\Exceptions;

use App\Services\WFC\Exceptions\WFCException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\PermissionException;
use App\Exceptions\MobileException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof WFCException || $exception instanceof PermissionException) {
            //if($request->ajax())
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        if ($exception instanceof MobileException) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], $exception->getCode());
        }

        if ($exception instanceof ViewException) {
            abort(400);
        }



        return parent::render($request, $exception);
    }
}

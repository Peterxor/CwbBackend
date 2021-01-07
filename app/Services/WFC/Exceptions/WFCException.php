<?php

namespace App\Services\WFC\Exceptions;

use Exception;
use Throwable;

class WFCException extends Exception
{
    protected $message = '未知錯誤';

    protected $code = 500;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

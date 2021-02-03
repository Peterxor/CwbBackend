<?php


namespace App\Exceptions;
use Throwable;
use Exception;

class MobileException extends Exception
{
    public function __construct($message = "mobile error", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

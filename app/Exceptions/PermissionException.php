<?php


namespace App\Exceptions;
use Throwable;
use Exception;

class PermissionException extends Exception
{
    public function __construct($message = "permission denied", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

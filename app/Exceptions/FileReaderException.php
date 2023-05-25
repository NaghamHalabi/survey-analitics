<?php

namespace App\Exceptions;

use Exception;

class FileReaderException extends Exception
{
    public function __construct($message = "Error reading file", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

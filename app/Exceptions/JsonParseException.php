<?php

namespace App\Exceptions;

use Exception;

class JsonParseException extends Exception
{
    public function __construct($message = "Error parsing JSON", $json = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}

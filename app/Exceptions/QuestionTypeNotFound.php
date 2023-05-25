<?php

namespace App\Exceptions;

use Exception;

class QuestionTypeNotFound extends Exception
{
    public function __construct($message = "No implementation found for question type:", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

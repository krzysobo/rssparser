<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Exception;

use Exception;

class FieldDoesNotExistException extends Exception
{
    public function __construct(
        $message,
        $code = 0,
        Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

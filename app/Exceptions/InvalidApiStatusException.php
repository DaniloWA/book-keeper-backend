<?php

namespace App\Exceptions;

use Throwable;
use InvalidArgumentException;

class InvalidApiStatusException extends InvalidArgumentException
{
    public function __construct($message = "Status must be 'Success' or 'Error'.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

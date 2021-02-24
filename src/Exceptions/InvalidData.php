<?php

namespace Leijman\FmpApiSdk\Exceptions;

use Exception;

class InvalidData extends Exception
{
    public static function invalidDataProvided(string $message)
    {
        return new static($message);
    }
}
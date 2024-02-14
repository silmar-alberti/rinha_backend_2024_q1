<?php

namespace App\Core\CreateTransaction\Exceptions;

use App\Core\Dependencies\Exceptions\HttpExceptionInterface;

class OutOfLimitException extends \Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return 422;
    }
}

<?php

namespace App\Core\CreateTransaction\Exceptions;

use App\Core\Dependencies\Exceptions\HttpExceptionInterface;

class BadRequestException extends \Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return 422;
    }
}

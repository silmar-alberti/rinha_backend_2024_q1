<?php

namespace App\Core\CreateTransaction\Exceptions;

use App\Core\Dependencies\Exceptions\HttpExceptionInterface;

class NotFoundException extends \Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return 404;
    }
}

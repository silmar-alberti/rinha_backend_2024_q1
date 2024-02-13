<?php

namespace App\Core\Dependencies\Exceptions;


interface HttpExceptionInterface extends \Throwable
{
    public function getStatusCode(): int;
}

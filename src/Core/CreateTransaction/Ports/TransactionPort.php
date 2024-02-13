<?php

namespace App\Core\CreateTransaction\Ports;

use App\Core\CreateTransaction\Dtos\RequestDataDto;

interface TransactionPort
{
    public function create(RequestDataDto $request): void;
}

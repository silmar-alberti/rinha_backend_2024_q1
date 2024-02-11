<?php

namespace Core\CreateTransaction\Ports;

use Core\CreateTransaction\Dtos\RequestDataDto;

interface TransactionPort
{
    public function create(RequestDataDto $request): void;
}

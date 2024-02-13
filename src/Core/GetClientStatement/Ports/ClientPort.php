<?php

namespace App\Core\GetClientStatement\Ports;

use App\Core\GetClientStatement\Dtos\ClientDto;

interface ClientPort
{
    public function getCurrentBalance(int $clientId): ClientDto;
}

<?php

namespace App\Core\CreateTransaction\Ports;

use App\Core\CreateTransaction\Dtos\ClientDto;

interface ClientPort {

    public function getForUpdate(int $clientId): ClientDto;

    public function updateCurrentBalance(int $clientId, int $currentBalance): void;
}
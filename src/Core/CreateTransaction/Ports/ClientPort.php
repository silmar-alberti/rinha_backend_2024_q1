<?php

namespace Core\CreateTransaction\Ports;

use Core\CreateTransaction\Dtos\ClientDto;

interface ClientPort {

    public function getForUpdate(int $clientId): ClientDto;

    public function updateCurrentBalance(int $clientId, $currentBalance): void;
}
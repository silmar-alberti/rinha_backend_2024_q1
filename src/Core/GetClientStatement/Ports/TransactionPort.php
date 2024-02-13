<?php

namespace App\Core\GetClientStatement\Ports;

use App\Core\GetClientStatement\Dtos\TransactionDto;

interface TransactionPort
{
    /**
     * @return array<TransactionDto> $transactions
     */
    public function getLastByClient(int $clientId, int $amount = 10): array;
}

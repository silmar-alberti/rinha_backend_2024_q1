<?php

namespace App\Core\GetClientStatement;

use App\Core\GetClientStatement\Dtos\ResponseDataDto;
use App\Core\GetClientStatement\Ports\ClientPort;
use App\Core\GetClientStatement\Ports\TransactionPort;

class UseCase
{
    public function __construct(
        private readonly ClientPort $clientPort,
        private readonly TransactionPort $transactionPort,
    ) {
    }

    public function execute(int $clientId): ResponseDataDto
    {
        $client = $this->clientPort->getCurrentBalance(clientId: $clientId);
        $transactions = $this->transactionPort->getLastByClient(clientId: $clientId);

        return new ResponseDataDto(
            queryTime: $client->queryTime,
            credit: $client->credit,
            currentBalance: $client->currentBalance,
            transactions: $transactions
        );
    }
}

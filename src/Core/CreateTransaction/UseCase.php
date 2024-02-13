<?php

namespace App\Core\CreateTransaction;

use App\Core\CreateTransaction\Dtos\RequestDataDto;
use App\Core\CreateTransaction\Dtos\ResponseDataDto;
use App\Core\CreateTransaction\Ports\ClientPort;
use App\Core\CreateTransaction\Ports\DbTransactionPort;
use App\Core\CreateTransaction\Ports\TransactionPort;
use App\Core\CreateTransaction\ValueObjects\TransactionTypeVo;

class UseCase
{
    public function __construct(
        private readonly ClientPort $clientPort,
        private readonly TransactionPort $transactionPort,
        private readonly DbTransactionPort $dbTransactionPort,
    ) {
    }

    public function execute(RequestDataDto $request): ResponseDataDto
    {
        return $this->dbTransactionPort->wrapTransaction(
            function () use ($request): ResponseDataDto {
                
                $response = match ($request->type) {
                    TransactionTypeVo::CREDIT => $this->credit(request: $request),
                    TransactionTypeVo::DEBIT => $this->debit(request: $request),
                    default => throw new \Exception('invalid transaction type'),
                };

                $this->createTransaction(request: $request);

                return $response;
            }
        );
    }

    private function debit(RequestDataDto $request): ResponseDataDto
    {
        $client = $this->clientPort->getForUpdate($request->clientId);
        if ($client->currentBalance + $client->credit > $request->value) {
            $currentBalance = $client->currentBalance - $request->value;
        }

        $this->clientPort->updateCurrentBalance(clientId: $client->id, currentBalance: $currentBalance);

        return new ResponseDataDto(
            currentBalance: $currentBalance,
            credit: $client->credit,
        );
    }

    private function credit(RequestDataDto $request)
    {
        $client = $this->clientPort->getForUpdate(clientId: $request->clientId);
        $currentBalance  = $client->currentBalance + $request->value;
        $this->clientPort->updateCurrentBalance(clientId: $client->id, currentBalance: $currentBalance);

        return new ResponseDataDto(
            currentBalance: $currentBalance,
            credit: $client->credit,
        );
    }

    private function createTransaction(RequestDataDto $request): void
    {
        $this->transactionPort->create(request: $request);
    }
}

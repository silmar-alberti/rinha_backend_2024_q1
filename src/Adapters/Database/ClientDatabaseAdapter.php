<?php

namespace App\Adapters\Database;

use App\Core\CreateTransaction\Dtos\ClientDto;
use App\Core\CreateTransaction\Exceptions\NotFoundException;
use App\Core\CreateTransaction\Ports\ClientPort;
use App\Core\GetClientStatement\Dtos\ClientDto as DtosClientDto;
use App\Core\GetClientStatement\Ports\ClientPort as GetStatementClientPort;
use App\Core\GetClientStatement\Exceptions\NotFoundException as GetStatementNotFoundException;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Exception;

class ClientDatabaseAdapter implements ClientPort, GetStatementClientPort
{

    public function __construct(
        private readonly Connection $conn,
    ) {
    }

    public function getForUpdate(int $clientId): ClientDto
    {
        $clientData = $this->conn->fetchAssociative(
            query: <<<SQL
                SELECT
                    credit, current_balance
                FROM client
                WHERE id = :id
                FOR UPDATE
                LIMIT 1
            SQL,
            params: [
                'id' => $clientId
            ],
        );

        if ($clientData === false) {
            throw new NotFoundException("Client {$clientId} was not found");
        }

        return new ClientDto(
            id: $clientId,
            currentBalance: $clientData['current_balance'],
            credit: $clientData['credit'],
        );
    }

    public function updateCurrentBalance(int $clientId, int $currentBalance): void
    {

        $rows = $this->conn->executeStatement(
            sql: <<<SQL
                UPDATE client
                SET "current_balance" = :currentBalance
                WHERE id = :id
            SQL,
            params: [
                'currentBalance' => $currentBalance,
                'id' => $clientId
            ],

        );

        if ($rows !== 1) {
            throw new Exception("Error on update current_balance client {$clientId}");
        }
    }

    public function getCurrentBalance(int $clientId): DtosClientDto
    {
        $clientData = $this->conn->fetchAssociative(
            query: <<<SQL
                SELECT
                    credit, current_balance, now() as "query_date"
                FROM client
                WHERE id = :id
                LIMIT 1
            SQL,
            params: [
                'id' => $clientId
            ],
        );

        if ($clientData === false) {
            throw new GetStatementNotFoundException("Client {$clientId} was not found");
        }

        return new DtosClientDto(
            currentBalance: $clientData['current_balance'],
            credit: $clientData['credit'],
            queryTime: new DateTimeImmutable($clientData['query_date']),
        );
    }
}

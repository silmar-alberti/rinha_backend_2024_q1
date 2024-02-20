<?php

namespace App\Adapters\Database;

use App\Core\CreateTransaction\Dtos\RequestDataDto;
use App\Core\CreateTransaction\Ports\TransactionPort;
use App\Core\GetClientStatement\Dtos\TransactionDto;
use App\Core\GetClientStatement\Ports\TransactionPort as GetStatementTransactionPort;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class TransactionDatabaseAdapter implements TransactionPort, GetStatementTransactionPort
{
    public function __construct(
        private readonly Connection $conn,
    ) {
    }

    public function create(RequestDataDto $request): void
    {
        $rows = $this->conn->executeStatement(
            sql: <<<SQL
                INSERT INTO "transaction" ("client_id", "type", "value", "description")
                VALUES (:clientId , :type, :value, :description);
            SQL,
            params: [
                'clientId' => $request->clientId,
                'type' => $request->type->value,
                'value' => $request->value->value,
                'description' => $request->description->value,
            ]
        );

        if ($rows !== 1) {
            throw new \Exception('Somethig wrong on transaction saving');
        }
    }

    public function getLastByClient(int $clientId, int $amount = 10): array
    {
        $transactions = $this->conn->fetchAllAssociative(
            query: <<<SQL
                SELECT
                    "value", "type", "created_date", "description"
                FROM "transaction"
                WHERE client_id = :id
                ORDER BY id desc
                LIMIT :limit
            SQL,
            params: [
                'id' => $clientId,
                'limit' => $amount,
            ],
        );


        return array_map(
            fn (array $data) => new TransactionDto(
                value: $data['value'],
                type: $data['type'],
                description: $data['description'],
                createdAt: new DateTimeImmutable($data['created_date']),
            ),
            $transactions
        );
    }
}

<?php

namespace App\Core\GetClientStatement\Dtos;

use DateTimeImmutable;

/**
 * @property array<TransactionDto> $transactions
 */
class ResponseDataDto
{
    /**
     * @param array<TransactionDto> $transactions
     */
    public function __construct(
        public readonly DateTimeImmutable $queryTime,
        public readonly int $credit,
        public readonly int $currentBalance,
        public readonly array $transactions,
    ) {
    }
}

<?php

namespace App\Core\GetClientStatement\Dtos;


class ClientDto
{
    public function __construct(
        public readonly int $currentBalance,
        public readonly int $credit,
        public readonly \DateTimeImmutable $queryTime,
    ) {
    }
}

<?php

namespace App\Core\GetClientStatement\Dtos;

class TransactionDto
{
    public function __construct(
        public readonly int $value,
        public readonly string $type,
        public readonly string $description,
        public readonly \DateTimeImmutable $createdAt,
    ) {
    }
}

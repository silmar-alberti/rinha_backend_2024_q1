<?php

namespace Core\CreateTransaction\Dtos;

use Core\CreateTransaction\ValueObjects\DescriptionVo;
use Core\CreateTransaction\ValueObjects\TransactionTypeVo;

class RequestDataDto
{
    public function __construct(
        public readonly int $clientId,
        public readonly TransactionTypeVo $type,
        public readonly int $value,
        public readonly DescriptionVo $description,
    ) {
    }
}

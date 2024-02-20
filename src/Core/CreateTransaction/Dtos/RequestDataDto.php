<?php

namespace App\Core\CreateTransaction\Dtos;

use App\Core\CreateTransaction\ValueObjects\DescriptionVo;
use App\Core\CreateTransaction\ValueObjects\TransactionTypeVo;
use App\Core\CreateTransaction\ValueObjects\ValueVo;

class RequestDataDto
{
    public function __construct(
        public readonly int $clientId,
        public readonly TransactionTypeVo $type,
        public readonly ValueVo $value,
        public readonly DescriptionVo $description,
    ) {
    }
}

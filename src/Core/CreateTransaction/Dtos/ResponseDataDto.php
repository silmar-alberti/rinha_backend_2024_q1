<?php

namespace Core\CreateTransaction\Dtos;

class ResponseDataDto
{
    public function __construct(
        public readonly int $currentBalance,
        public readonly int $credit,
    ) {
    }
}

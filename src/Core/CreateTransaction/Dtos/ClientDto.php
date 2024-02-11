<?php

namespace Core\CreateTransaction\Dtos;


class ClientDto
{
    public function __construct(
        public readonly int $id,
        public readonly int $currentBalance,
        public readonly int $credit,
    ) {
    }
}

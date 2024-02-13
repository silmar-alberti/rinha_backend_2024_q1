<?php

namespace App\Core\CreateTransaction\ValueObjects;


class DescriptionVo {
    public function __construct(
        public readonly string $value,
    )
    {
        if (strlen($this->value) > 10){
            throw new \Exception('Transaction description must have less than 10 chars');
        }
    }
}
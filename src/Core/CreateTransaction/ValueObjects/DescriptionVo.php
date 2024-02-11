<?php

namespace Core\CreateTransaction\ValueObjects;


class DescriptionVo {
    public function __construct(
        public readonly string $description,
    )
    {
        if (strlen($this->description) > 10){
            throw new \Exception('Transaction description must have less than 10 chars');
        }
    }
}
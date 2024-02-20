<?php

namespace App\Core\CreateTransaction\ValueObjects;

use App\Core\CreateTransaction\Exceptions\BadRequestException;

class DescriptionVo {

    public readonly string $value;

    public function __construct(
        ?string $value,
    )
    {
        if ($value === null) {
            throw new BadRequestException('Transaction description must be an string');
        }

        $length = strlen($value);
        if ($length > 10 || $length <= 0 ){
            throw new BadRequestException('Transaction description must have less than 10 chars');
        }

        $this->value = $value;
    }
}

<?php

namespace App\Core\CreateTransaction\ValueObjects;

use App\Core\CreateTransaction\Exceptions\BadRequestException;

class ValueVo {
    public readonly int $value;

    public function __construct(
        mixed $value
    )
    {
        if (is_int($value) === false) {
            throw new BadRequestException('value must be an integer');
        }

        if ($value < 0) {
            throw new BadRequestException('value must greather than or equal 0');
        }

        $this->value = $value;
    }
}

<?php

namespace App\Core\CreateTransaction\ValueObjects;

use App\Core\CreateTransaction\Exceptions\BadRequestException;

enum TransactionTypeVo: string
{
    case CREDIT = 'c';
    case DEBIT = 'd';

    public static function create(?string $value): self
    {   
        if ($value === null) {
            throw new BadRequestException("Invalid transaction type must not be null}");
        }

        $val = self::tryFrom($value);
        if ($val !== null) {
            return $val;
        }

        throw new BadRequestException("Invalid transaction type {$value}");
    }
}

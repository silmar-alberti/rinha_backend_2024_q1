<?php

namespace Core\CreateTransaction\ValueObjects;

enum TransactionTypeVo: string {
    case CREDIT = 'c';
    case DEBIT = 'd'; 
}
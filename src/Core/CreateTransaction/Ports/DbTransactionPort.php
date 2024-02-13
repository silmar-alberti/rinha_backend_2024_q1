<?php

namespace App\Core\CreateTransaction\Ports;

use Closure;

interface DbTransactionPort {
    public function wrapTransaction(Closure $fn): mixed; 
}
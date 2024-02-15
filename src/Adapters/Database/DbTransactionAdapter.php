<?php

namespace App\Adapters\Database;

use App\Core\CreateTransaction\Ports\DbTransactionPort;
use Closure;
use Doctrine\DBAL\Connection;

class DbTransactionAdapter implements DbTransactionPort
{
    public function __construct(
        private readonly Connection $conn,
    ) {
    }

    public function wrapTransaction(Closure $fn): mixed
    {
        // return $fn();
        return $this->conn->transactional(func: $fn);
    }
}

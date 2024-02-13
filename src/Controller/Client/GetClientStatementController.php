<?php

namespace App\Controller\Client;

use App\Adapters\Database\ClientDatabaseAdapter;
use App\Adapters\Database\TransactionDatabaseAdapter;
use App\Core\Dependencies\Exceptions\HttpExceptionInterface;
use App\Core\GetClientStatement\Dtos\TransactionDto;
use App\Core\GetClientStatement\UseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetClientStatementController extends AbstractController
{

    public function __construct(
        private readonly ClientDatabaseAdapter $clientDatabaseAdapter,
        private readonly TransactionDatabaseAdapter $transactionDatabaseAdapter,
    ) {
    }

    #[Route(path: "/clientes/{clientId}/extrato")]
    public function getStatement(int $clientId): JsonResponse
    {
        try {
            $useCase = new UseCase(
                clientPort: $this->clientDatabaseAdapter,
                transactionPort: $this->transactionDatabaseAdapter,
            );
    
            $response = $useCase->execute(clientId: $clientId);
    
            return new JsonResponse([
                'saldo' => [
                    'total' => $response->currentBalance,
                    'data_extrato' => $response->queryTime->format(DATE_RFC3339_EXTENDED),
                    'limite' => $response->credit,
                    'ultimas_transacoes' => array_map(
                        callback: fn (TransactionDto $t) => [
                            'valor' => $t->value,
                            'tipo' => $t->type,
                            'descricao' => $t->description,
                            'realizada_em' => $t->createdAt->format(DATE_RFC3339_EXTENDED),
                        ],
                        array: $response->transactions
                    )
                ]
            ]);

        }catch(HttpExceptionInterface $ex){
            return new JsonResponse(status: $ex->getStatusCode());
        }
    }
}

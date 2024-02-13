<?php

namespace App\Controller\Client;

use App\Adapters\Database\ClientDatabaseAdapter;
use App\Adapters\Database\DbTransactionAdapter;
use App\Adapters\Database\TransactionDatabaseAdapter;
use App\Core\CreateTransaction\Dtos\RequestDataDto;
use App\Core\CreateTransaction\UseCase;
use App\Core\CreateTransaction\ValueObjects\DescriptionVo;
use App\Core\CreateTransaction\ValueObjects\TransactionTypeVo;
use App\Core\Dependencies\Exceptions\HttpExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostClientTransactionController extends AbstractController
{

    public function __construct(
        private readonly ClientDatabaseAdapter $clientDatabaseAdapter,
        private readonly TransactionDatabaseAdapter $transactionDatabaseAdapter,
        private readonly DbTransactionAdapter $dbTransactionAdapter,
    ) {
    }

    #[Route(path: '/clientes/{clientId}/transacoes')]
    public function createTransaction(int $clientId, Request $request): JsonResponse
    {
        try {
            $useCase = new UseCase(
                clientPort: $this->clientDatabaseAdapter,
                transactionPort: $this->transactionDatabaseAdapter,
                dbTransactionPort: $this->dbTransactionAdapter,
            );

            $response = $useCase->execute($this->getRequestData(
                clientId: $clientId,
                request: $request,
            ));

            return new JsonResponse([
                'limite' => $response->credit,
                'saldo' => $response->currentBalance,
            ]);
        } catch (HttpExceptionInterface $ex) {
            return new JsonResponse(status: $ex->getStatusCode());
        }
    }

    private function getRequestData(int $clientId, Request $request): RequestDataDto
    {
        $content = json_decode($request->getContent(), true);

        return new RequestDataDto(
            clientId: $clientId,
            type: TransactionTypeVo::from($content['tipo']),
            value: $content['valor'],
            description: new DescriptionVo($content['descricao'])
        );
    }
}

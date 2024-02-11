<?php

declare(strict_types=1);

namespace App\Controller\Client;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostClientTransactionController extends AbstractController
{

    public function __construct(
        private readonly Connection $conn
    ) {
    }

    #[Route(path: '/clientes/{clientId}/transacoes')]
    public function createTransaction(int $clientId, Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $result = $this->conn->fetchAllAssociative('SELECT * FROM client');

        return new JsonResponse([
            'clientId' => $clientId,
            'content' => $content,
            'er' => $result,
        ]);
    }
    
}

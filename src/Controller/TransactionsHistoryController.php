<?php

namespace App\Controller;

use App\Interface\TransactionHistoryRepositoryInterface;
use App\Repository\TransactionHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class TransactionsHistoryController extends AbstractController
{
    public function __construct(
        public TransactionHistoryRepositoryInterface $transactionHistoryRepository
    )
    {
    }

    #[Route('/transactions-history', name: 'app_transactions_history', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        [$accountId, $offset, $limit] = $this->getRequiredParams($request);

        $transactionList = $this->transactionHistoryRepository->findPaginatedByAccountId($accountId, $limit, $offset);

        return $this->json(array_reverse($transactionList) ?? []);
    }

    private function getRequiredParams(Request $request): array
    {
        $accountId = $request->get('account_id');

        if (empty($accountId)) {
            throw new \Exception('Account id is missing or empty');
        }

        $offset = $request->get('offset');
        $limit = $request->get('limit');

        return [
            $accountId,
            $offset,
            $limit
        ];
    }
}

<?php

namespace App\Controller;

use App\Interface\TransactionHistoryRepositoryInterface;
use App\Repository\TransactionHistoryRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

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
        try {
            [$accountId, $offset, $limit] = $this->getRequiredParams($request);

            $transactionList = $this->transactionHistoryRepository->findPaginatedByAccountId($accountId, $limit, $offset);

            return $this->json(array_reverse($transactionList) ?? []);
        } catch (Throwable $exception) {
            return $this->json(
                data: ['message' => "Error while processing. {$exception->getMessage()}"],
                status: Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @throws Exception
     */
    private function getRequiredParams(Request $request): array
    {
        $accountId = $request->get('account_id');

        if (empty($accountId)) {
            throw new Exception('Account id is missing or empty');
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

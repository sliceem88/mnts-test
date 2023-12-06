<?php

namespace App\Controller;

use App\Interface\TransactionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class TransactionController extends AbstractController
{
    public function __construct(
        public TransactionInterface $transaction
    ){
    }

    #[Route('/make-transaction', name: 'app_transaction', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $requiredParams = $this->getRequiredParams($request);

        try {
            $transactionId = $this->transaction->make(...$requiredParams);

            if($transactionId === false) {
                return $this->json(
                    data: ['message' => 'Transaction failed, please check you account data'],
                    status: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->json([
                'transactionId' => $transactionId,
                'message' => 'Transaction was successful, please check you account data'
            ]);

        } catch (Throwable $exception) {
            return $this->json(
                data: ['message' => "Error while processing. {$exception->getMessage()}"],
                status: Response::HTTP_BAD_REQUEST
            );
        }
    }

    //TODO: move validation to own validator???
    private function getRequiredParams(Request $request): array | JsonResponse
    {
        $data = [
          'accountIdFrom' => $request->get('id_from'),
          'accountIdTo' => $request->get('id_to'),
          'amount' => $request->get('amount'),
          'currency' => $request->get('currency')
        ];

        foreach ($data as $key => $value) {
            if(empty($value) || !is_string($value)) {
                return $this->json(
                    data: ['message' => "Missing required parameter: $key, please check"],
                    status: Response::HTTP_BAD_REQUEST
                );
            }
        }

        return $data;
    }
}

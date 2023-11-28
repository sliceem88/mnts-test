<?php

namespace App\Controller;

use App\Interface\TransactionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
        $transactionId = $this->transaction->make(...$requiredParams);

        if($transactionId === false) {
            throw new \Exception('Transaction failed');
        }

        return $this->json([
           'transactionId' => $transactionId,
           'message' => 'Transaction was successful, please check you account data'
        ]);
    }

    //TODO: move validation to own validator???
    private function getRequiredParams(Request $request): array
    {
        $data = [
          'accountIdFrom' => $request->get('id_from'),
          'accountIdTo' => $request->get('id_to'),
          'amount' => $request->get('amount'),
          'currency' => $request->get('currency')
        ];

        foreach ($data as $key => $value) {
            if(empty($value) || !is_string($value)) {
                throw new \Exception("Missing required parameter: $key, please check");
            }
        }

        return $data;
    }
}

<?php

namespace App\Controller;

use App\Interface\AccountsRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

final class AccountListController extends AbstractController
{
    public function __construct(
        public AccountsRepositoryInterface $accountsRepository
    ){
    }

    #[Route('/account-list', name: 'app_account_list', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $userId = $request->get('client_id');

        if(empty($userId)) {
            throw new \Exception('User id is missing or empty');
        }

        $account = $this->accountsRepository->getByUserId($userId);

        return $this->json($account ?? []);
    }
}

<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Accounts;

final class AccountsFactory
{
    public function create(array $params): Accounts
    {
        return (new Accounts())->setAccountId($params['account_id'])
            ->setUserId($params['user_id'])
            ->setAmount($params['amount'])
            ->setName($params['name'])
            ->setEmail($params['email'])
            ->setCurrency($params['currency']);
    }
}
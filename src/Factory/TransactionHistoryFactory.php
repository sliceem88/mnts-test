<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\TransactionHistory;

final class TransactionHistoryFactory
{
    public function create(): TransactionHistory
    {
        return new TransactionHistory();
    }
}
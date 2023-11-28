<?php
declare(strict_types=1);

namespace App\Interface;

interface TransactionHistoryRepositoryInterface
{
    public function findPaginatedByAccountId(string $accountId, string $limit = null, string $offset = null): ?array;
}
<?php
declare(strict_types=1);

namespace App\Interface;

interface AccountsRepositoryInterface
{
    public function getByUserId(string $userId): ?array;
}
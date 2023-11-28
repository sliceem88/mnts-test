<?php
declare(strict_types=1);

namespace App\Interface;

interface TransactionInterface
{
    public function make(string $accountIdFrom, string $accountIdTo, float $amount, string $currency): bool|int ;
}
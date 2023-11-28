<?php
declare(strict_types=1);

namespace App\Interface;

interface CurrencyExchangeInterface
{
    public function exchange(float $amount, string $currencyFrom, string $currencyTo): float ;
}
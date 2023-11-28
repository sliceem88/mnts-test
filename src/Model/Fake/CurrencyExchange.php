<?php
declare(strict_types=1);

namespace App\Model\Fake;

use App\Interface\CurrencyExchangeInterface;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When(env: 'test')]
final class CurrencyExchange implements CurrencyExchangeInterface
{
    public function exchange(float $amount, string $currencyFrom, string $currencyTo): float
    {
        if($amount > 10) {
            return 12.2;
        }

        return 0.0;
    }
}
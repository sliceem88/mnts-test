<?php

namespace App\Model\Fake;

use App\Entity\Accounts;
use App\Factory\TransactionHistoryFactory;
use App\Interface\AccountsRepositoryInterface;
use App\Interface\CurrencyExchangeInterface;
use App\Interface\TransactionHistoryRepositoryInterface;
use App\Interface\TransactionInterface;
use App\Model\CurrencyExchange;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When(env: 'test')]
final class Transaction implements TransactionInterface
{
    private Accounts $accountFrom;
    private Accounts $accountTo;
    private float $amount;
    private ?string $currency;

    public function __construct(
        private AccountsRepositoryInterface           $accountsRepository,
        private CurrencyExchangeInterface             $currencyExchange,
        private TransactionHistoryRepositoryInterface $transactionHistoryRepository,
        private TransactionHistoryFactory             $transactionHistoryFactory,
    ){
    }

    /**
     * @throws \Exception
     */
    public function make(string $accountIdFrom, string $accountIdTo, float $amount, string $currency): bool|int
    {
        [$accountFrom, $accountTo] = $this->getAccounts([$accountIdFrom, $accountIdTo]);

        return $this->setAccountFrom($accountFrom)
            ->setAccountTo($accountTo)
            ->setAmount($amount)
            ->setCurrency($currency)
            ->process();
    }

    /**
     * @return Accounts[]
     */
    private function getAccounts(array $accountList): array
    {
        return [
            (new Accounts())->setCurrency('EUR')->setAmount(12),
            (new Accounts())->setCurrency('USD')->setAmount(12)
        ];
    }

    private function process(): bool|int
    {
        $convertedAmount = $this->currencyExchange->exchange($this->amount, $this->accountFrom->getCurrency(), $this->accountTo->getCurrency());

        if ($convertedAmount > 0) {
            $transactionId = $this->updateTransActionHistory($convertedAmount);

            $this->updateAccounts($convertedAmount);

            return $transactionId;
        }

        return false;
    }

    private function setAccountFrom(Accounts $accountFrom): self
    {
        $this->accountFrom = $accountFrom;

        return $this;
    }

    private function setAccountTo(Accounts $accountTo): self
    {
        $this->accountTo = $accountTo;

        return $this;
    }

    private function setAmount(float $amount): self
    {
        if ($this->accountFrom->getAmount() < $amount) {
            throw new \Exception("Transaction can't be completed, insufficient fund on your account");
        }

        $this->amount = $amount;

        return $this;
    }

    private function setCurrency(?string $currency): self
    {
        if ($this->accountTo->getCurrency() !== $currency) {
            throw new \Exception("Transaction can't be completed, as currency $currency doesn't match to transition account");
        }

        $this->currency = $currency;

        return $this;
    }

    private function updateAccounts(float $convertedAmount): void
    {
        return;
    }

    private function updateTransActionHistory(float $convertedAmount): int
    {
        return 3;
    }
}

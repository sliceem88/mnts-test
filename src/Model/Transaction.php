<?php

namespace App\Model;

use App\Entity\Accounts;
use App\Factory\TransactionHistoryFactory;
use App\Interface\AccountsRepositoryInterface;
use App\Interface\CurrencyExchangeInterface;
use App\Interface\TransactionHistoryRepositoryInterface;
use App\Interface\TransactionInterface;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When(env: 'dev')]
#[When(env: 'prod')]
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
    )
    {
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
        return array_map(fn($accountId) => $this->accountsRepository->findOneBy(['account_id' => $accountId]), $accountList);
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
        $accounts = [$this->accountTo, $this->accountFrom];

        $this->accountFrom->reduceAmount($this->amount);
        $this->accountTo->increaseAmount($convertedAmount);

        array_walk($accounts, fn($account) => $this->accountsRepository->save($account, true));
    }

    //TODO: move to TransactionHistory class or to Observer ??
    private function updateTransActionHistory(float $convertedAmount): int
    {
        $transaction = $this->transactionHistoryFactory->create();
        $transaction->setAmountFrom($this->amount)
            ->setAmountTo($convertedAmount)
            ->setAmountFrom($this->amount)
            ->setAccountId($this->accountFrom->getAccountId())
            ->setAccountIdTo($this->accountTo->getAccountId())
            ->setCurrencyFrom($this->accountFrom->getCurrency())
            ->setCurrencyTo($this->accountTo->getCurrency());

        $this->transactionHistoryRepository->save($transaction, true);

        return $transaction->getId();
    }
}

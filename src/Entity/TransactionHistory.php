<?php

namespace App\Entity;

use App\Repository\TransactionHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionHistoryRepository::class)]
final class TransactionHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $account_id = null;

    #[ORM\Column]
    private ?float $amount_from = null;

    #[ORM\Column]
    private ?float $amount_to = null;

    #[ORM\Column(length: 3)]
    private ?string $currency_from = null;

    #[ORM\Column(length: 3)]
    private ?string $currency_to = null;

    #[ORM\Column(length: 50)]
    private ?string $account_id_to = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?self
    {
        $this->id = $id;

        return $this;
    }

    public function getAccountId(): ?string
    {
        return $this->account_id;
    }

    public function setAccountId(string $account_id): self
    {
        $this->account_id = $account_id;

        return $this;
    }

    public function getAmountFrom(): ?float
    {
        return $this->amount_from;
    }

    public function setAmountFrom(float $amount_from): self
    {
        $this->amount_from = $amount_from;

        return $this;
    }

    public function getAmountTo(): ?float
    {
        return $this->amount_to;
    }

    public function setAmountTo(float $amount_to): self
    {
        $this->amount_to = $amount_to;

        return $this;
    }

    public function getCurrencyFrom(): ?string
    {
        return $this->currency_from;
    }

    public function setCurrencyFrom(string $currency_from): self
    {
        $this->currency_from = $currency_from;

        return $this;
    }

    public function getCurrencyTo(): ?string
    {
        return $this->currency_to;
    }

    public function setCurrencyTo(string $currency_to): self
    {
        $this->currency_to = $currency_to;

        return $this;
    }

    public function getAccountIdTo(): ?string
    {
        return $this->account_id_to;
    }

    public function setAccountIdTo(string $account_id_to): self
    {
        $this->account_id_to = $account_id_to;

        return $this;
    }
}

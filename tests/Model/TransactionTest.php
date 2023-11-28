<?php

namespace App\Tests\Model;

use App\Entity\Accounts;
use App\Entity\TransactionHistory;
use App\Factory\TransactionHistoryFactory;
use App\Model\CurrencyExchange;
use App\Model\Transaction;
use App\Repository\AccountsRepository;
use App\Repository\TransactionHistoryRepository;
use PHPUnit\Framework\TestCase;

/**
 * Final class Mock will work, usage of DG\BypassFinals::enable() is set in bootstrap.php
 */
class TransactionTest extends TestCase
{
    public function getMocked(): array
    {
        $accountRep = $this->getMockBuilder(AccountsRepository::class)->disableOriginalConstructor()->getMock();
        $currExch = $this->getMockBuilder(CurrencyExchange::class)->disableOriginalConstructor()->getMock();
        $transHistRep = $this->getMockBuilder(TransactionHistoryRepository::class)->disableOriginalConstructor()->getMock();
        $transHistFact = $this->getMockBuilder(TransactionHistoryFactory::class)->disableOriginalConstructor()->getMock();

        return [
            $accountRep,
            $currExch,
            $transHistRep,
            $transHistFact
        ];
    }

    public function getMockedFail(): Transaction
    {
        [$accountRep, $currExch, $transHistRep, $transHistFact] = $this->getMocked();

        $accountRep->expects($this->exactly(2))->method('findOneBy')->willReturn((new Accounts())->setAccountId('asdasd')->setCurrency('EUR')->setAmount(12));
        $currExch->expects($this->any())->method('exchange')->willReturn(10.0);
        $transHistRep->expects($this->any())->method('save')->willReturnSelf();
        $transHistFact->expects($this->any())->method('create')->willReturn((new TransactionHistory())->setId(12));

        return new Transaction(
            $accountRep,
            $currExch,
            $transHistRep,
            $transHistFact
        );
    }

    public function test_make_method(): void
    {
        [$accountRep, $currExch, $transHistRep, $transHistFact] = $this->getMocked();

        $accountRep->expects($this->exactly(2))->method('findOneBy')->willReturn((new Accounts())->setAccountId('asdasd')->setCurrency('EUR')->setAmount(12));
        $currExch->expects($this->once())->method('exchange')->willReturn(10.0);
        $transHistRep->expects($this->any())->method('save')->willReturnSelf();
        $transHistFact->expects($this->once())->method('create')->willReturn((new TransactionHistory())->setId(12));

        $transition = new Transaction(
            $accountRep,
            $currExch,
            $transHistRep,
            $transHistFact
        );

        $result = $transition->make('asdasd', 'asdasd', '6', 'EUR');

        $this->assertIsInt($result);
    }

    public function test_make_method_fail_currency(): void
    {
        $transition = $this->getMockedFail();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Transaction can't be completed, as currency USD doesn't match to transition account");
        $transition->make('asdasd', 'asdasd', '6', 'USD');
    }

    public function test_make_method_fail_insufficient(): void
    {
        $transition = $this->getMockedFail();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Transaction can't be completed, insufficient fund on your account");
        $transition->make('asdasd', 'asdasd', '56', 'USD');
    }

    public function test_make_method_fail_process(): void
    {
        [$accountRep, $currExch, $transHistRep, $transHistFact] = $this->getMocked();

        $accountRep->expects($this->exactly(2))->method('findOneBy')->willReturn((new Accounts())->setAccountId('asdasd')->setCurrency('EUR')->setAmount(12));
        $currExch->expects($this->once())->method('exchange')->willReturn(0.0);
        $transHistRep->expects($this->any())->method('save')->willReturnSelf();

        $transition = new Transaction(
            $accountRep,
            $currExch,
            $transHistRep,
            $transHistFact
        );

        $result = $transition->make('asdasd', 'asdasd', '6', 'EUR');

        $this->assertIsBool($result);
    }
}

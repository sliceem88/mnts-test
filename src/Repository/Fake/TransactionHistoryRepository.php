<?php

namespace App\Repository\Fake;

use App\Entity\TransactionHistory;
use App\Interface\TransactionHistoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\When;

/**
 * @extends ServiceEntityRepository<TransactionHistory>
 *
 * @method TransactionHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionHistory[]    findAll()
 * @method TransactionHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
#[When(env: 'test')]
class TransactionHistoryRepository extends ServiceEntityRepository implements TransactionHistoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionHistory::class);
    }

    public function save(TransactionHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TransactionHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ?TransactionHistory[]
     */
    public function findPaginatedByAccountId(string $accountId, string $limit = null, string $offset = null): ?array
    {
        return [
            [
                "id" => 3,
                "account_id" => "MDI75ORX5PX",
                "amount_from" => 10,
                "amount_to" => 10,
                "currency_from" => "EUR",
                "currency_to" => "EUR",
                "account_id_to" => "BLD14KPC6BF"
            ],
            [
                "id" => 2,
                "account_id" => "MDI75ORX5PX",
                "amount_from" => 10,
                "amount_to" => 10,
                "currency_from" => "EUR",
                "currency_to" => "EUR",
                "account_id_to" => "BLD14KPC6BF"
            ]
        ];
    }
}

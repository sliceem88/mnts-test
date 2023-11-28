<?php

namespace App\Repository;

use App\Entity\Accounts;
use App\Interface\AccountsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\When;

/**
 * @extends ServiceEntityRepository<Accounts>
 *
 * @method Accounts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accounts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accounts[]    findAll()
 * @method Accounts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
#[When(env: 'dev')]
#[When(env: 'prod')]
class AccountsRepository extends ServiceEntityRepository implements AccountsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accounts::class);
    }

    public function save(Accounts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Accounts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param string $userId
     *
     * @return ?Accounts[]
     */
    public function getByUserId(string $userId): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.user_id = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getArrayResult();
    }
}

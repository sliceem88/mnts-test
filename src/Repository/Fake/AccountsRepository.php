<?php

namespace App\Repository\Fake;

use App\Entity\Accounts;
use App\Factory\AccountsFactory;
use App\Interface\AccountsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\When;

/**
 * @extends ServiceEntityRepository<Accounts>
 *
 * @method Accounts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accounts[]    findAll()
 * @method Accounts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
#[When(env: 'test')]
class AccountsRepository extends ServiceEntityRepository implements AccountsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry,public AccountsFactory $accountsFactory)
    {
        parent::__construct($registry, Accounts::class);
    }
    /**
     * @param string $userId
     *
     * @return ?Accounts[]
     */
    public function getByUserId(string $userId): ?array
    {
        return [
            'id' => 11,
            'name' => 'Semen Ditua',
            'email' => 'bit@trepu.fr',
            'account_id' => 'MDI75ORX5PX',
            'currency' => 'USD',
            'user_id' => 1,
            'amount' => 0.66
        ];
    }
}

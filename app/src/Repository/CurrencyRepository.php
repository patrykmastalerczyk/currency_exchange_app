<?php

namespace App\Repository;

use App\Dto\CurrencyDto;
use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Currency>
 *
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    public function findById(Uuid $id): ?Currency
    {
        return $this->find($id);
    }

    public function findByName(string $name): ?Currency
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function upsert(Currency $currency): void
    {
        if ($currency->getId() === null) {
            $this->getEntityManager()->persist($currency);
        }

        $this->getEntityManager()->flush();
    }
}

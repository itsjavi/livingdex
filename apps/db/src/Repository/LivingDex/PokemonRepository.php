<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    /**
     * @param string $orderBy
     * @return Pokemon[]
     */
    public function findAllSorted(string $orderBy = 'id'): iterable
    {
        return $this->createQueryBuilder('p')
            ->orderBy($orderBy)
            ->getQuery()
            ->getResult();
    }

    public function findOneByDexNum(int $num): ?Pokemon
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.dexNum = :val')
            ->setParameter('val', $num)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneBySlug(string $slug): ?Pokemon
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.slug = :val')
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

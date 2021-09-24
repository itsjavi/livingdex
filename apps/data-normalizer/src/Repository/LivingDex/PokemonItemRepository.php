<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\PokemonItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonItem[]    findAll()
 * @method PokemonItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonItem::class);
    }

    // /**
    //  * @return PokemonItem[] Returns an array of PokemonItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PokemonItem
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

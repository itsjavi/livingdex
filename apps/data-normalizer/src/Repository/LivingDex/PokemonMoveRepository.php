<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\PokemonMove;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonMove|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonMove|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonMove[]    findAll()
 * @method PokemonMove[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonMoveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonMove::class);
    }

    // /**
    //  * @return PokemonMove[] Returns an array of PokemonMove objects
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
    public function findOneBySomeField($value): ?PokemonMove
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

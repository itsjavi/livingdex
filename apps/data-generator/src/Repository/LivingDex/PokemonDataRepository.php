<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\PokemonData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonData|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonData|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonData[]    findAll()
 * @method PokemonData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonData::class);
    }

    // /**
    //  * @return PokemonData[] Returns an array of PokemonData objects
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
    public function findOneBySomeField($value): ?PokemonData
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

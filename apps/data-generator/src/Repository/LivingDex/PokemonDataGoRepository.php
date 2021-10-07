<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\PokemonDataGo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonDataGo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonDataGo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonDataGo[]    findAll()
 * @method PokemonDataGo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonDataGoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonDataGo::class);
    }

    // /**
    //  * @return PokemonDataGo[] Returns an array of PokemonDataGo objects
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
    public function findOneBySomeField($value): ?PokemonDataGo
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

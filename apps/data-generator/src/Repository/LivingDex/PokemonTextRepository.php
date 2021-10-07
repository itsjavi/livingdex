<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\PokemonText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonText|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonText|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonText[]    findAll()
 * @method PokemonText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonText::class);
    }

    // /**
    //  * @return PokemonText[] Returns an array of PokemonText objects
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
    public function findOneBySomeField($value): ?PokemonText
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

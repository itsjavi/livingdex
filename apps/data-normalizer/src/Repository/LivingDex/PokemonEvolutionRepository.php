<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\PokemonEvolution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonEvolution|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonEvolution|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonEvolution[]    findAll()
 * @method PokemonEvolution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonEvolutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonEvolution::class);
    }

    // /**
    //  * @return PokemonEvolution[] Returns an array of PokemonEvolution objects
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
    public function findOneBySomeField($value): ?PokemonEvolution
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

<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\GameGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameGroup[]    findAll()
 * @method GameGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameGroup::class);
    }

    // /**
    //  * @return GameGroup[] Returns an array of GameGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameGroup
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

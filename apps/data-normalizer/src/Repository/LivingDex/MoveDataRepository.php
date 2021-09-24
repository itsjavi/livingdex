<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\MoveData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MoveData|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoveData|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoveData[]    findAll()
 * @method MoveData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoveDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoveData::class);
    }

    // /**
    //  * @return MoveData[] Returns an array of MoveData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MoveData
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

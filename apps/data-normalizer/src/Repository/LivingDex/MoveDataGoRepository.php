<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\MoveDataGo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MoveDataGo|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoveDataGo|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoveDataGo[]    findAll()
 * @method MoveDataGo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoveDataGoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoveDataGo::class);
    }

    // /**
    //  * @return MoveDataGo[] Returns an array of MoveDataGo objects
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
    public function findOneBySomeField($value): ?MoveDataGo
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

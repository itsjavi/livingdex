<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\MoveText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MoveText|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoveText|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoveText[]    findAll()
 * @method MoveText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoveTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoveText::class);
    }

    // /**
    //  * @return MoveText[] Returns an array of MoveText objects
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
    public function findOneBySomeField($value): ?MoveText
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

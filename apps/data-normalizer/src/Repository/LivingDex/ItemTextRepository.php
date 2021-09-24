<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\ItemText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ItemText|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemText|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemText[]    findAll()
 * @method ItemText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemText::class);
    }

    // /**
    //  * @return ItemText[] Returns an array of ItemText objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemText
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

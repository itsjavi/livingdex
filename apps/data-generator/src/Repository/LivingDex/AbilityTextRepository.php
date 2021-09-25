<?php

namespace App\Repository\LivingDex;

use App\Entity\LivingDex\AbilityText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AbilityText|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbilityText|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbilityText[]    findAll()
 * @method AbilityText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbilityTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbilityText::class);
    }

    // /**
    //  * @return AbilityText[] Returns an array of AbilityText objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AbilityText
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

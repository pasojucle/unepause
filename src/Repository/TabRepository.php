<?php

namespace App\Repository;

use App\Entity\Tab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tab|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tab|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tab[]    findAll()
 * @method Tab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tab::class);
    }

    // /**
    //  * @return Tab[] Returns an array of Tab objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Tab
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

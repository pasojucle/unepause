<?php

namespace App\Repository;

use App\Entity\PageContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageContainer[]    findAll()
 * @method PageContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageContainer::class);
    }

    // /**
    //  * @return PageContainer[] Returns an array of PageContainer objects
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
    public function findOneBySomeField($value): ?PageContainer
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

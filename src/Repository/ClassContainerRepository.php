<?php

namespace App\Repository;

use App\Entity\ClassContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClassContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassContainer[]    findAll()
 * @method ClassContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassContainer::class);
    }

    // /**
    //  * @return ClassContainer[] Returns an array of ClassContainer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClassContainer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

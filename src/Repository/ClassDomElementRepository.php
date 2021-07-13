<?php

namespace App\Repository;

use App\Entity\ClassDomElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClassDomElement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassDomElement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassDomElement[]    findAll()
 * @method ClassDomElement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassDomElementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassDomElement::class);
    }

    // /**
    //  * @return ClassDomElement[] Returns an array of ClassDomElement objects
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
    public function findOneBySomeField($value): ?ClassDomElement
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

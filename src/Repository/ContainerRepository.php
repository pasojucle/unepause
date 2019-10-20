<?php

namespace App\Repository;

use App\Entity\Container;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Container|null find($id, $lockMode = null, $lockVersion = null)
 * @method Container|null findOneBy(array $criteria, array $orderBy = null)
 * @method Container[]    findAll()
 * @method Container[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Container::class);
    }

    // /**
    //  * @return Container[] Returns an array of Container objects
    //  */


    public function findAllContainers()
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.actions', 'a')
            ->join('a.pages', 'p')
            ->join('p.pageContainers', 'pc')
            ->join('pc.pageContents', 'pct')
            ;
        ;

        return $qb;
    }



    /*
    public function findOneBySomeField($value): ?Container
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

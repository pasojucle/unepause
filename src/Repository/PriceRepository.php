<?php

namespace App\Repository;

use App\Entity\Price;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Price|null find($id, $lockMode = null, $lockVersion = null)
 * @method Price|null findOneBy(array $criteria, array $orderBy = null)
 * @method Price[]    findAll()
 * @method Price[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Price::class);
    }

    // /**
    //  * @return Price[] Returns an array of Price objects
    //  */
    
    public function findByPage($page)
    {
        $qb = $this->createQueryBuilder('pri')
        ->join('pri.product', 'pro')
        ->join('pro.family', 'f')
        ->join('f.article', 'a')
        ->join('a.page', 'pa')
        ->join('pa.acrion', 'ta')
        ;
        if (null == $page) {
            $page = 'prices';
        } 
        $qb->andWhere(
            $qb->expr()->like('pa.slug', ':page')
        )
        ->setParameter('page', $page);

        return $qb;
    }
    

    /*
    public function findOneBySomeField($value): ?Price
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

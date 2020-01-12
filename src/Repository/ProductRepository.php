<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
    * @return Product 
    */
    public function findByProduct($product): ?Product
    {
        $qb = $this->createQueryBuilder('p');
        return $qb->leftJoin('p.prices', 'pr')
            ->leftJoin('p.timeLines', 't')
            ->leftJoin('p.images', 'i')
            ->andWhere(
                $qb->expr()->eq('p.id',':id')
            )
            ->setParameter('id', $product->getId())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }



    /*
    public function findOneBySomeField($value): ?Product
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

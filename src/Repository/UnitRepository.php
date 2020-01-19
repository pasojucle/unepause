<?php

namespace App\Repository;

use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Unit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unit[]    findAll()
 * @method Unit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    /**
    * @return Units[] Returns an array of Units objects
    */

    public function findByProduct($product)
    {
        $products[] = $product->getId();
        $family = $product->getFamily();
        $parent = $family->getParent();
        if ($family->getHasUniquesPrices() == true && $parent === null) {
            $products[] = $family->getGenericProduct()->getId();
        }
        if ($parent !== null && $parent->getGenericProduct() !== null) {
            $products[] = $parent->getGenericProduct()->getId();
        }
        $qb = $this->createQueryBuilder('u');
        return $qb->leftJoin('u.families', 'f')
            ->leftJoin('f.products', 'p')
            ->where(
                $qb->expr()->in('p.id', ':products')
            )
            ->setParameter('products', $products)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Units
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

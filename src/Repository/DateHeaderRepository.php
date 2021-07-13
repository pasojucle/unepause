<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\DateHeader;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method DateHeader|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateHeader|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateHeader[]    findAll()
 * @method DateHeader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateHeaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateHeader::class);
    }

    public function findAll(): array
    {
        $qb = $this->createQueryBuilder('dh');
        return $qb->where(
                $qb->expr()->eq('dh.isGeneric', 0)
            )
            ->orderBy('dh.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findAvailabitityQuantity($dateHeader){
        $qb = $this->createQueryBuilder('d');
        $qb->leftJoin('d.bookings', 'b')
            ->select('SUM(b.quantity) AS bookingQuantity')
            ->andWhere(
                $qb->expr()->eq('d.id', ':dateHeader')
            )
            ->setParameter('dateHeader', $dateHeader->getId());

        $bookingQuantity = $qb->getQuery()->getSingleScalarResult();
        
        if (null == $bookingQuantity) {
            $bookingQuantity = 0;
        }

        return  $dateHeader->getMaxQuantity() - $bookingQuantity;
    }

    public function findNextDateHeaders ($limit = null): array
    {
        $qb = $this->createQueryBuilder('dh');
        $qb->join('dh.dateLines', 'dl')
            ->where(
                $qb->expr()->gt('dl.date', ':now')
            )
            ->setParameter('now', new \DateTime('now'))
            ->groupBy('dh.id')
            ->orderBy('dl.date', 'ASC');
        if (null != $limit) {
            $qb->setMaxResults($limit);
        }
            
        return $qb->getQuery()->getResult();
    }

    public function findGeneric(Product $product):?DateHeader
    {
        $qb = $this->createQueryBuilder('dh');
        return  $qb->andWhere(
                $qb->expr()->eq('dh.isGeneric', 1)
            )
            ->andWhere(
                $qb->expr()->eq('dh.product', ':product')
            )
            ->setParameter('product', $product->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }
}

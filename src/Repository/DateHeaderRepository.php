<?php

namespace App\Repository;

use App\Entity\DateHeader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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

}

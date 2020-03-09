<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\DateHeader;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
    * @return Booking[] Returns an array of Booking objects
    */
    public function findByDateHeader(DateHeader $dateHeader)
    {
        $qb = $this->createQueryBuilder('b');
        return $qb->andWhere(
                $qb->expr()->eq('b.dateHeader', ':date_header')
            )
            ->setParameter('date_header', $dateHeader->getId())
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findNextBookings ($limit = null): array
    {
        $qb = $this->createQueryBuilder('b');
        $qb->join('b.dateHeader', 'dh')
            ->join('dh.dateLines', 'dl')
            ->where(
                $qb->expr()->gt('dl.date', ':now')
            )
            ->setParameter('now', new \DateTime('now'))
            ->groupBy('b.dateHeader')
            ;
       if (null != $limit) {
            $qb->setMaxResults($limit);
        }
            
        return $qb->getQuery()->getResult();
    }
}

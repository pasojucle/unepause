<?php

namespace App\Repository;

use App\Entity\TimeLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TimeLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeLine[]    findAll()
 * @method TimeLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeLine::class);
    }

    // /**
    //  * @return TimeLine[] Returns an array of TimeLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TimeLine
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAvailabitityQuantity($timeLine){
        $qb = $this->createQueryBuilder('t');
        $qb->leftJoin('t.bookings', 'b')
            //->select($qb->expr()->diff('t.maxQuantity', 'SUM(b.quantity)').' AS availabilityQuantity')
            ->select('SUM(b.quantity) AS bookingQuantity')
            ->andWhere(
                $qb->expr()->eq('t.id', ':timeLine')
            )
            ->setParameter('timeLine', $timeLine->getId());

        $bookingQuantity = $qb->getQuery()->getSingleScalarResult();
        
        if (null == $bookingQuantity) {
            $bookingQuantity = 0;
        }

        return  $timeLine->getMaxQuantity() - $bookingQuantity;
    }

}

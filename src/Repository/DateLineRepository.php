<?php

namespace App\Repository;

use App\Entity\DateLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DateLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateLine[]    findAll()
 * @method DateLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateLine::class);
    }

    // /**
    //  * @return DateLine[] Returns an array of DateLine objects
    //  */
    /*
    public function findAllOrder($value)
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
    public function findOneBySomeField($value): ?DateLine
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
    public function findNextDateLines (): array
    {
        $qb = $this->createQueryBuilder('t');
        return $qb->where(
            $qb->expr()->gt('t.day', ':now')
        )
        ->setParameter('now', new \DateTime('now'))
        ->getQuery()->getResult();
    }
}

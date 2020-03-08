<?php

namespace App\Repository;

use App\Entity\Price;
use App\Entity\Product;
use App\Entity\DateHeader;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    
    public function findByProductDateHeader(Product $product, ?DateHeader $dateHeader): ?float {
        
        $unitPrice = $product->getPrices()[0];

        if (null !== $dateHeader) {
            $products = [];
            $product = $dateHeader->getProduct();
            if (null !== $product) {
                $products[] = $product->getId();
                $family = $product->getFamily();
                $parent = $family->getParent();
                if ($family->getHasUniquesPrices() == true && $parent === null) {
                    $products[] = $family->getGenericProduct()->getId();
                }
                if ($parent !== null && $parent->getGenericProduct() !== null) {
                    $products[] = $parent->getGenericProduct()->getId();
                }
            }

            $qb = $this->createQueryBuilder('pri');
            $qb->leftJoin('pri.product', 'pro')
                ->leftJoin('pro.dateHeaders', 'dh')
                ->leftJoin('pro.family', 'fa')
                ->leftJoin('fa.products', 'pros')
                ->andWhere(
                    $qb->expr()->eq('pri.unit', ':unit')
                )
                ->andWhere(
                    $qb->expr()->in('pri.product', ':products')
                )
                ->setParameters([
                    'unit'=> $dateHeader->getunit(),
                    'products'=> $products
                ]);

            $unitPrice = $qb->getQuery()
                ->getOneOrNullResult();

        }
        return ($unitPrice !== null) ? $unitPrice->getAmount(): null;
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

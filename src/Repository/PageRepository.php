<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    // /**
    //  * @return Page[] Returns an array of Page objects
    //  */

    public function findBySlug($action, $page = null)
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.action', 'a')
            ->join('p.pageContainers', 'pc')
            ->join('pc.pageContents', 'pct')
            ->leftJoin('pc.families', 'f')
            ->leftJoin('f.products', 'pr')
            ->join('p.template', 't')
            ->join('t.route', 'r')
            ;
        if (null == $page) {
            $page = $action;
        } 
        $qb->andWhere(
            $qb->expr()->like('p.slug', ':page'),
            $qb->expr()->like('a.slug', ':action')
        )
        ->setParameter('action', $action)
        ->setParameter('page', $page)
        ;

        return $qb->getQuery()
            ->getOneOrNullResult();

        /*$page = [];
        foreach($pageObject->getPageContents() as $pageContent) {
            $containerId = $pageContent->getPageContainer()->getId();
            $page[$containerId][]= $pageContent;
        }
        $page['template'] = $pageObject->getTemplate()->getFilename();
        $page['action'] = $pageObject->getAction()->getName();

        return $page;*/
    }

    /*
    public function findOneBySomeField($value): ?Page
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

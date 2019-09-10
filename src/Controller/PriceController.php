<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PriceController extends AbstractController
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/prices/{page}", name="prices", defaults={"page": null})
     */
    public function prices($page)
    {
        $articles = $this->manager->getRepository(Article::class)->findBySlug('prices', $page)
            ->getQuery()
            ->getResult();
        /*$prices = $this->manager->getRepository(Price::class)->findByPage($page)
        ->getQuery()
        ->getResult();*/

        return $this->render('price/show.html.twig', [
            'articles' => $articles,
        ]);
    }
}

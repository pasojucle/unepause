<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $repo;

    public function __construct(ArticleRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/prices/{page}", name="prices", defaults={"page": null})
     */
    public function prices()
    {

        //$action = $manager->getRepository(Action::class)->findOneBySlug($slug);
        $articles = [];

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{tab}/{page}", name="show_article", defaults={"page": null})
     */
    public function showArticle($tab, $page)
    {
        $articles = $this->repo->findBySlug($tab, $page)
            ->getQuery()
            ->getResult();

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }



}

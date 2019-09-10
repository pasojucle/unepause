<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("a/{tab}/{page}", name="show_article", defaults={"page": null})
     */
    public function showArticle($tab, $page)
    {
        $articles = $this->manager->getRepository(Article::class)->findBySlug($tab, $page)
            ->getQuery()
            ->getResult();

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }



}

<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/{tab}/{page}", name="show_article", defaults={"page": null})
     */
    public function showArticle(ObjectManager $manager, $tab, $page)
    {
        $articles = $manager->getRepository(Article::class)->findBySlug($tab, $page);

        dump($articles);
        //$action = $manager->getRepository(Action::class)->findOneBySlug($slug);
        //$articles = $action->getArticles()->toArray();

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }

        /**
     * @Route("/prices", name="prices")
     */
    public function showPrices(ObjectManager $manager)
    {
        //$action = $manager->getRepository(Action::class)->findOneBySlug($slug);
        //$articles = $action->getArticles()->toArray();

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }

}

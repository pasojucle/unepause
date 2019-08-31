<?php

namespace App\Controller;

use App\Entity\Action;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/massage/{slug}", name="massage")
     */
    public function massage(ObjectManager $manager, $slug)
    {
        $action = $manager->getRepository(Action::class)->findBySlug($slug);
        $articles = $action->getArticles()->toArray();

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/practice", name="practice")
     */
    public function practice(ObjectManager $manager)
    {
        $action = $manager->getRepository(Action::class)->findBySlug($slug);
        $articles = $action->getArticles()->toArray();

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/prices", name="prices")
     */
    public function prices()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}

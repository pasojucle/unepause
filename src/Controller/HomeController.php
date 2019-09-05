<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $repo)
    {
        $article = $repo->findBySlug('home')
        ->getQuery()
        ->getOneOrNullResult();  
        
        return $this->render('home/index.html.twig', [
            'article' => $article,
        ]);
    }
}

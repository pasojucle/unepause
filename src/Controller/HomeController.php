<?php

namespace App\Controller;

use App\Repository\PageContentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/homettt", name="homerr")
     */
    /*public function index(PageContentRepository $repo)
    {
        $article = $repo->findBySlug('home')
        ->getQuery()
        ->getOneOrNullResult();  
        
        return $this->render('home/index.html.twig', [
            'article' => $article,
            'template' => 'home',
        ]);
    }*/
}

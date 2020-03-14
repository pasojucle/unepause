<?php

namespace App\Controller;

use App\Entity\PageContent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageContentController extends AbstractController
{
    /**
     * @Route("/admin/page/content/edit/{pageContent}", name="page_content_edit")
     */
    public function edit(PageContent $pageContent)
    {
        return $this->render('page_content/edit.html.twig', [
            'controller_name' => 'PageContentController',
        ]);
    }
}

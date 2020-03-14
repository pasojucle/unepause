<?php

namespace App\Controller;

use App\Entity\PageContainer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageContainerController extends AbstractController
{
    /**
     * @Route("/admin/page/container/{pageContainer}", name="page_container_edit")
     */
    public function edit(PageContainer $pageContainer)
    {
        return $this->render('page_container/edit.html.twig', [
            'controller_name' => 'PageContainerController',
        ]);
    }
}

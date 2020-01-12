<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/admin/", name="admin_dashboard")
     */
    public function adminDashboard()
    {
        return $this->render('Admin/dashboard.html.twig', [
            'controller_name' => 'AdminDefaultController',
        ]);
    }
}

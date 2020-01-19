<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\TimeLine;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/admin/", name="admin_dashboard")
     */
    public function adminDashboard(ObjectManager $manager)
    {
        $bookings = $manager->getRepository(Booking::class)->findAll();
        $TimeLines = $manager->getRepository(TimeLine::class)->findNextTimeLines();
        return $this->render('Admin/dashboard.html.twig', [
            'bookings' => $bookings,
            'timeLines' => $TimeLines,
        ]);
    }
}

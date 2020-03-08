<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\DateHeader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function adminDashboard(ObjectManager $manager)
    {
        return $this->render('Admin/dashboard.html.twig', [
            'bookings' => $manager->getRepository(Booking::class)->findNextBookings(4),
            'dateHeaders' => $manager->getRepository(DateHeader::class)->findNextDateHeaders(4),
            'action_slug' => 'dashboard',
            'page_slug' => 'dashboard',
        ]);
    }
}

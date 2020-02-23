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
     * @Route("/admin/", name="admin_dashboard")
     */
    public function adminDashboard(ObjectManager $manager)
    {
        $bookings = $manager->getRepository(Booking::class)->findNextBookings(3);
        $dateHeaders = $manager->getRepository(DateHeader::class)->findNextDateHeaders(3);
        return $this->render('Admin/dashboard.html.twig', [
            'bookings' => $bookings,
            'dateHeaders' => $dateHeaders,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\DateHeader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function adminDashboard(EntityManagerInterface $manager)
    {
        return $this->render('dashboard.html.twig', [
            'bookings' => $manager->getRepository(Booking::class)->findNextBookings(4),
            'dateHeaders' => $manager->getRepository(DateHeader::class)->findNextDateHeaders(4),
            'action_slug' => 'dashboard',
            'page_slug' => 'dashboard',
        ]);
    }
}

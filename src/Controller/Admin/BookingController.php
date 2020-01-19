<?php

namespace App\Controller\Admin;

use App\Repository\BookingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings", name="admin_bookings")
     */
    public function bookings(BookingRepository $bookingRepository)
    {
        $bookings = $bookingRepository->findAll();
        return $this->render('Admin/booking/list.html.twig', [
            'bookings' => $bookings,
        ]);
    }
}

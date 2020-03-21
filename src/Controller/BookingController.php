<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Product;
use App\Form\BookingType;
use App\Form\ContactType;
use App\Service\BookingService;
use App\Service\ProductService;
use App\Repository\PriceRepository;
use App\Service\EmailMessageService;
use App\Repository\BookingRepository;
use App\Repository\DateHeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/admin/booking", name="booking_list")
     */
    public function list(BookingRepository $bookingRepository)
    {
        $bookings = $bookingRepository->findAll();
        return $this->render('Admin/booking/list.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * @Route(
     * "/booking/{id}",
     *  name="booking",
     * options={"expose"=true}
     * )
     */
    public function booking(
        Request $request,
        PriceRepository $priceRepo,
        EmailMessageService $emailService,
        DateHeaderRepository $dateHeaderRepo,
        ProductService $productService,
        BookingService $bookingService,
        EntityManagerInterface $manager,
        SessionInterface $session,
        Product $product)
    {
        $product = $manager->getRepository(Product::class)->findByProduct($product);
        $dateHeaders = $productService->getAvailabilitiesQuantities($product);
        $session->set('target_route',$request->attributes->get("_route"));
        $session->set('target_route_params',$request->attributes->get("_route_params"));
        $price = null;

        dump($session);

        $booking = new Booking();
        $booking->setProduct($product);
        if (!empty($dateHeaders) && null === $booking->getDateHeader()) {
            $booking->setDateHeader($dateHeaders[0]);
        }
        
        $form = $this->createForm(BookingType::class, $booking,[
            'dateHeaders' => $dateHeaders,
        ]);

        $form->handleRequest($request);
        $booking = $form->getData();

        if($request->isXmlHttpRequest()) {
            $form = $this->createForm(BookingType::class, $booking,[
                'dateHeaders' => $dateHeaders,
            ]);
        }

        if(!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $booking->setUser($user);
            $manager->persist($booking);
            $manager->flush();

            $send = $emailService->sendBookingConfirmation($booking);

            return $this->redirectToRoute('booking_confirmation', [
                'booking' => $booking->getId(),
                'send' => $send,
            ]); 

        }
        return $this->render('booking/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'price' => $price,
        ]);
    }


    /**
     * @Route("/booking/confirmation/{booking}/{send}", name="booking_confirmation", defaults={"send": 0})
     */
    public function bookingConfirmation(Booking $booking, int $send)
    {
        if (1 == $send) {
            $this->addFlash(
                'success',
                'Votre demande à bien été envoyée !'
            );
        } else {
            $this->addFlash(
                'warning',
                'une erreure s\'est produite. Essayez à nouveau !'
            );
        }

        return $this->render('booking/confirmation.html.twig', [
            'booking' => $booking,
        ]);
    }
  }

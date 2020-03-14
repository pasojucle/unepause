<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ContactType;
use App\Service\BookingService;
use App\Service\ProductService;
use App\Repository\PriceRepository;
use App\Service\EmailMessageService;
use App\Repository\BookingRepository;
use App\Repository\DateHeaderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
        Product $product)
    {
        $product = $this->manager->getRepository(Product::class)->findByProduct($product);
        $dateHeaders = $productService->getAvailabilitiesQuantities($product);

        $price = null;

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
            $booking->setUser($this->getUser());
            $this->manager->persist($booking);
            $this->manager->flush();

            $send = $emailService->sendBookingConfirmation($booking);

            return $this->redirectToRoute('user_account', [
                'user' => $this->getUser()->getId(),
                'send' => $send,
            ]);
        }
        return $this->render('booking/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'price' => $price,
        ]);
    }
  }

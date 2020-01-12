<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Action;
use App\Entity\Booking;
use App\Entity\Product;
use App\Entity\TimeLine;
use App\Form\BookingType;
use App\Form\ContactType;
use App\Form\AppointmentType;
use App\Service\ProductService;
use App\Repository\PriceRepository;
use App\Service\EmailMessageService;
use App\Repository\TimeLineRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $manager;
    private $emailMessageService;

    public function __construct(ObjectManager $manager, EmailMessageService $emailMessageService)
    {
        $this->manager = $manager;
        $this->emailMessageService = $emailMessageService;
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
        TimeLineRepository $timeLineRepo,
        ProductService $productService,
        Product $product)
    {
        $product = $this->manager->getRepository(Product::class)->findByProduct($product);
        $timeLines = $productService->getAvailabilitiesQuantities($product);

        $price = null;

        $booking = new Booking();
        $booking->setProduct($product);
        if (!empty($timeLines) && null === $booking->getTimeLine()) {
            $booking->setTimeLine($timeLines[0]);
        }
        $price = $priceRepo->findByBooking($booking);
        $booking->setPrice($price);
        $form = $this->createForm(BookingType::class, $booking,[
            'timeLines' => $timeLines,
        ]);

        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            $booking = $form->getData();
            $price = $priceRepo->findByBooking($booking);
            $booking->setPrice($price);

            $form = $this->createForm(BookingType::class, $booking,[
                'timeLines' => $timeLines,
            ]);

            return $this->render('booking/edit.html.twig', [
                'form' => $form->createView(),
                'product' => $product,
                'price' => $price,
            ]);
        }

        if($form->isSubmitted() && $form->isValid()) {
            $booking = $form->getData();
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
    
    /**
    * @Route(
    * "/appointment/{id}",
    *  name="appointment",
    * options={"expose"=true}
    * )
    */
   public function appointment(Request $request, Product $product)
   {
       $product = $this->manager->getRepository(Product::class)->findByProduct($product);

       $form = $this->createForm(ContactType::class);

       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()) {

       }
       return $this->render('appointment/edit.html.twig', [
           'form' => $form->createView(),
           'product' => $product,
       ]);
   }


    /**
     * @Route(
     * "/",
     * name="home",
     * defaults={"actionSlug": null, "pageSlug": null},
     * methods={"GET"}
     * )
     * @Route(
     * "page/{actionSlug}/{pageSlug}",
     * name="show_page",
     * defaults={"actionSlug": null, "pageSlug": null},
     * methods={"GET"}
     * )
     */
    public function showPage(Request $request, $actionSlug, $pageSlug)
    {
        if (null == $actionSlug) {
            $actionSlug = 'home';
        }
        $page = $this->manager->getRepository(Page::class)->findBySlug($actionSlug, $pageSlug);

        return $this->render($page->getTemplate()->getFilename(), [
            'page' => $page,
            'action_slug' => $actionSlug,
            'page_slug' => $pageSlug,
        ]);
    }



}

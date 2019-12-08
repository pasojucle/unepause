<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Action;
use App\Entity\Booking;
use App\Entity\Product;
use App\Entity\TimeLine;
use App\Form\BookingType;
use App\Form\ContactType;
use App\Service\EmailMessageService;
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
     * @Route("/booking/{id}", name="booking")
     */
    public function booking(Product $product, Request $request)
    {
        $product = $this->manager->getRepository(Product::class)->findByProduct($product);
        $timeLine = $this->manager->getRepository(TimeLine::class)->findBy(['product' => $product]);

        $booking = new Booking();
        if (!empty($timeLine) && null === $booking->getTimeLine()) {
            $booking->setTimeLine($timeLine[0]);
        }
        dump($booking);
        $form = $this->createForm(BookingType::class, $booking,[
            'timeLines' => $timeLine,
        ]);
dump($request);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $booking = $form->getData();
            $booking->setProduct($product)
                ->setUser($this->getUser());
            $this->manager->persist($booking);
            $this->manager->flush();
        }
        return $this->render('booking/edit.html.twig', [
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
        dump($page);
        dump($request->attributes);

        return $this->render($page->getTemplate()->getFilename(), [
            'page' => $page,
            'action_slug' => $actionSlug,
            'page_slug' => $pageSlug,
            //'form'=>$form->createView(),
        ]);
    }



}

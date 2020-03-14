<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Action;
use App\Entity\Booking;
use App\Entity\Product;
use App\Form\BookingType;
use App\Form\ContactType;
use App\Entity\DateHeader;
use App\Form\AppointmentType;
use App\Service\BookingService;
use App\Service\ProductService;
use App\Repository\PriceRepository;
use App\Service\EmailMessageService;
use App\Repository\DateHeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $manager;
    private $emailMessageService;

    public function __construct(EntityManagerInterface $manager, EmailMessageService $emailMessageService)
    {
        $this->manager = $manager;
        $this->emailMessageService = $emailMessageService;
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

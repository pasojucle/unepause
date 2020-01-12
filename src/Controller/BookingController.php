<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking_old", name="booking_old")
     */
    public function index()
    {
        if (null == $actionSlug) {
            $actionSlug = 'home';
        }
        $page = $this->manager->getRepository(Page::class)->findBySlug($actionSlug, $pageSlug);
        
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

  }

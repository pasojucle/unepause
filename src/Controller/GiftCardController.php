<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GiftCardController extends AbstractController
{
    /**
     * @Route("/gift/card", name="giftcard")
     */
    public function giftcard()
    {
        return $this->render('gift_card/index.html.twig', [
            'controller_name' => 'GiftCardController',
        ]);
    }
}

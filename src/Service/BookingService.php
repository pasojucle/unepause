<?php

namespace App\Service;

use App\Entity\Price;
use App\Entity\Booking;
use Doctrine\Common\Persistence\ObjectManager;

class BookingService
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

    }

    public function getPrice(Booking $booking): ?float
    {
        $timeLine = $booking->getTimeLine();
        $product = $booking->getProduct();

        $priceUnit = $this->manager->getRepository(Price::class)->findByProductTimeLine($product, $timeLine);
        dump($priceUnit);
        return ($priceUnit != null) ? $priceUnit * $booking->getQuantity() : null;
    }

}
<?php

namespace App\Service;

use App\Entity\Price;
use App\Entity\Booking;
use App\Entity\Product;
use App\Entity\DateHeader;
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
        $dateHeader = $booking->getDateHeader();
        $product = $booking->getProduct();

        $priceUnit = $this->manager->getRepository(Price::class)->findByProductDateHeader($product, $dateHeader);

        return ($priceUnit != null) ? $priceUnit * $booking->getQuantity() : null;
    }
}
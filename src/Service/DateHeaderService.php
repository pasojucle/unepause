<?php

namespace App\Service;

use App\Entity\Price;
use App\Entity\DateHeader;
use Doctrine\ORM\EntityManagerInterface;

class DateHeaderService
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

    }

    public function getPrice(DateHeader $dateHeader): ?float
    {
        $product = $dateHeader->getProduct();

        return $this->manager->getRepository(Price::class)->findByProductDateHeader($product, $dateHeader);
    }
}
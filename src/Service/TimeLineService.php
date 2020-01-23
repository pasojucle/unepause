<?php

namespace App\Service;

use App\Entity\Price;
use App\Entity\TimeLine;
use Doctrine\Common\Persistence\ObjectManager;

class TimeLineService
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

    }

    public function getPrice(TimeLine $timeLine): ?float
    {
        $product = $timeLine->getProduct();

        return $this->manager->getRepository(Price::class)->findByProductTimeLine($product, $timeLine);
    }
}
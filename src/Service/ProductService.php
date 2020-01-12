<?php

namespace App\Service;

use DateTime;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\TimeLineRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class ProductService
{
    private $productRepository;
    private $timeLineRepository;

    public function __construct(ProductRepository $productRepository, TimeLineRepository $timeLineRepository)
    {
        $this->productRepository = $productRepository;
        $this->timeLineRepository = $timeLineRepository;
    }

    public function getAvailabilitiesQuantities($product):?Collection {
        $timeLines = [];
        $timeLinesIterator =$product->getActiveTimeLines()->getIterator();
        foreach ($timeLinesIterator as $timeLine) {
            $availabitityQuantity = $this->timeLineRepository->findAvailabitityQuantity($timeLine);
            if ($availabitityQuantity > 0 || null == $availabitityQuantity) {
                $timeLine->setAvailabilityQuantity($availabitityQuantity);
                $timeLines[] = $timeLine;
            }
        }
        return new ArrayCollection($timeLines);
    }


}
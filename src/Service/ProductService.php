<?php

namespace App\Service;

use DateTime;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\DateHeaderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class ProductService
{
    private $productRepository;
    private $dateHeaderRepository;

    public function __construct(ProductRepository $productRepository, DateHeaderRepository $dateHeaderRepository)
    {
        $this->productRepository = $productRepository;
        $this->dateHeaderRepository = $dateHeaderRepository;
    }

    public function getAvailabilitiesQuantities($product):?Collection {
        $dateHeaders = [];
        $dateHeadersIterator = $product->getActiveDateHeaders()->getIterator();
        foreach ($dateHeadersIterator as $dateHeader) {
            $availabitityQuantity = $this->dateHeaderRepository->findAvailabitityQuantity($dateHeader);
            if ($availabitityQuantity > 0 || null == $availabitityQuantity) {
                $dateHeader->setAvailabilityQuantity($availabitityQuantity);
                $dateHeaders[] = $dateHeader;
            }
        }
        return new ArrayCollection($dateHeaders);
    }


}
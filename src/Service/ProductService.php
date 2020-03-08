<?php

namespace App\Service;

use DateTime;
use App\Entity\Unit;
use App\Entity\Product;
use App\Entity\DateHeader;
use App\Repository\UnitRepository;
use App\Repository\ProductRepository;
use App\Repository\DateHeaderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class ProductService
{
    private $productRepository;
    private $dateHeaderRepository;

    public function __construct(
        ProductRepository $productRepository,
        DateHeaderRepository $dateHeaderRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->dateHeaderRepository = $dateHeaderRepository;
    }

    public function getAvailabilitiesQuantities(Product $product):?Collection {
        $dateHeaders = [];
        $dateHeadersIterator = $product->getActiveDateHeaders()->getIterator();

        foreach ($dateHeadersIterator as $dateHeader) {
            $availabitityQuantity = $this->dateHeaderRepository->findAvailabitityQuantity($dateHeader);
            if ($availabitityQuantity > 0 || null == $availabitityQuantity) {
                $dateHeader->setAvailabilityQuantity($availabitityQuantity);
                $dateHeaders[] = $dateHeader;
            }
        }
        if ($product->getType() == Product::SCHEDULE_AND_APPOINTEMENT_SERVICE) { 
            $dateHeaders[] = $this->dateHeaderRepository->findGeneric($product);
        }
        
        return new ArrayCollection($dateHeaders);
    }
}
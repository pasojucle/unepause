<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{product}", name="product_show")
     */
    public function showProduct(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}

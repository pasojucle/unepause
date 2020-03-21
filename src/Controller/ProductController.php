<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{product}", name="product_show")
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/admin/product/edit/{product}", name="product_edit")
     */
    public function edit(Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

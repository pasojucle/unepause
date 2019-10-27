<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PriceController extends AbstractController
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/prices/{page}", name="show_prices", defaults={"page": null})
     */
    public function showPrices($page)
    {
        $page = $this->manager->getRepository(Page::class)->findBySlug($actionSlug, $pageSlug);

        return $this->render($page->getTemplate()->getFilename(), [
            'page' => $page,
            'action_slug' => $actionSlug,
            'page_slug' => $pageSlug,
        ]);
    }
}

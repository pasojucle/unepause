<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\Page;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/{actionSlug}/{pageSlug}", name="show_page", defaults={"actionSlug": null, "pageSlug": null})
     */
    public function showPage($actionSlug, $pageSlug)
    {
        if (null == $actionSlug) {
            $actionSlug = 'home';
        }
        $page = $this->manager->getRepository(Page::class)->findBySlug($actionSlug, $pageSlug);
dump($page->getPageContainers()->toArray());

        return $this->render($page->getTemplate()->getFilename(), [
            'page' => $page,
            'action_slug' => $actionSlug,
            'page_slug' => $pageSlug,
        ]);
    }



}

<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Action;
use App\Form\ContactType;
use App\Service\EmailMessageService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $manager;
    private $emailMessageService;

    public function __construct(ObjectManager $manager, EmailMessageService $emailMessageService)
    {
        $this->manager = $manager;
        $this->emailMessageService = $emailMessageService;
    }

    /**
     * @Route("/{actionSlug}/{pageSlug}", name="show_page", defaults={"actionSlug": null, "pageSlug": null}, methods={"GET"})
     */
    public function showPage(Request $request, $actionSlug, $pageSlug)
    {
        if (null == $actionSlug) {
            $actionSlug = 'home';
        }
        $page = $this->manager->getRepository(Page::class)->findBySlug($actionSlug, $pageSlug);
        /*$form = $this->createForm(ContactType::class, null, [
            'action' => $this->generateUrl($request->attributes->get('_route')).'#contact',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->emailMessageService->sendMessage($form);
        }*/

        return $this->render($page->getTemplate()->getFilename(), [
            'page' => $page,
            'action_slug' => $actionSlug,
            'page_slug' => $pageSlug,
            //'form'=>$form->createView(),
        ]);
    }



}

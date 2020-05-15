<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use App\Entity\Page;
use App\Entity\Article;
use App\Entity\Product;
use App\Form\ContactType;
use App\Service\ParameterService;
use App\Service\FormContactService;
use App\Service\EmailMessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    private $entityManager;
    private $emailMessageService;

    public function __construct(EntityManagerInterface $entityManager, EmailMessageService $emailMessageService)
    {
        $this->entityManager = $entityManager;
        $this->emailMessageService = $emailMessageService;
    }

    /**
     * @Route("/contact", name="show_contact", defaults={"product":null})
     * @Route("/informations/{product}", name="informations", defaults={"product":null})
     */
    public function showContact(Request $request, ParameterService $parameter, ?Product $product)
    {
        $actionSlug = preg_replace('#\/#', '', $request->getRequestUri());
        $page = $this->entityManager->getRepository(Page::class)->findBySlug($actionSlug);
        $tempate = $page->getTemplate()->getFilename();
        $form = $this->createForm(ContactType::class, null);
        $send = 0;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $send = $this->emailMessageService->sendConfirmation($data, $product);
            if (true == $send) {
                $this->addFlash('sucess', 'Votre message a été envoyé avec succés !');
            }
            return $this->redirectToRoute('home');
        }

        return $this->render($tempate, [
            'form'=>$form->createView(),
            'page' => $page,
            'send' => $send,
            'product' => $product,
            'template' => 'contact',
            'action_slug' => $actionSlug,
            'page_slug' => null,
        ]);
    }

    /**
     * @Route("/message/send", name="send_message", methods={"POST"}, condition="request.isXmlHttpRequest()")
    */

    public function sendMessage(FormContactService $formContactService, Request $request, ParameterService $parameter)
    {
        $form = $formContactService->getForm();
 
        $form->handleRequest($request);
 
        $send = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $send = $this->emailMessageService->sendConfirmation($data);
        }
        if (1 == $send) {
            $this->addFlash(
                'success',
                'Votre message à bien été envoyé !'
            );
        } else {
            $this->addFlash(
                'warning',
                'une erreure s\'est produite. Essayez à nouveau !'
            );
        }

        return new JsonResponse($this->renderView('partials/flashes.html.twig'));
    }

}

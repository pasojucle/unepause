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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="show_contact")
     * @Route("/informations/{product}", name="informations", defaults={"product":null})
     */
    public function showContact(ObjectManager $manager, Request $request,  EmailMessageService $emailService, ParameterService $parameter, ?Product $product)
    {
        $slug = $request->attributes->get('_route');
        $page = $manager->getRepository(Page::class)->findBySlug($slug);
        $tempate = $page->getTemplate()->getFilename();
        $form = $this->createForm(ContactType::class, null);
        $send = 0;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $emailService->sendConfirmation($data, $product);
        }
        return $this->render($tempate, [
            'form'=>$form->createView(),
            'page' => $page,
            'send' => $send,
            'product' => $product,
            'template' => 'contact',
        ]);
    }

    /**
     * @Route("/message/send", name="send_message", methods={"POST"}, condition="request.isXmlHttpRequest()")
    */

    public function sendMessage(FormContactService $formContactService, Request $request, EmailMessageService $emailService, ParameterService $parameter)
    {
        $form = $formContactService->getForm();
 
        $form->handleRequest($request);
 
        $send = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $send = $emailService->sendConfirmation($data);
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

<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use App\Entity\Article;
use App\Form\ContactType;
use App\Service\FormContactService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="show_contact")
     */
    public function showContact(ObjectManager $manager, Request $request,  Swift_Mailer $mailer)
    {
        $article = $manager->getRepository(Article::class)->findBySlug('contact')
        ->getQuery()
        ->getOneOrNullResult();
        $form = $this->createForm(ContactType::class, null);
        $send = 0;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $emailMessage = $form->getData();
            $parameters = $request->get('parameters');
            $message = (new Swift_Message('Message envoyé depuis le site "une pause"'))
            ->setFrom($emailMessage->getEmail())
            ->setTo($parameters['email'])
            ->setBody(
                $this->renderView(
                    'contact/emailMessage.html.twig',
                    ['email_message' => $emailMessage,]
                ),
                'text/html'
            );
            $send = $mailer->send($message);
        }
        return $this->render('contact/contact.html.twig', [
            'form'=>$form->createView(),
            'article' => $article,
            'send' => $send,
            'template' => 'contact',
        ]);
    }

    /**
     * @Route("/message/send", name="send_message", methods={"POST"}, condition="request.isXmlHttpRequest()")
    */

    public function sendMessage(FormContactService $formContactService, Request $request, Swift_Mailer $mailer)
    {
        $form = $formContactService->getForm();
 
        $form->handleRequest($request);
 
        $send = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            $emailMessage = $form->getData();
            $parameters = $request->get('parameters');
            $message = (new Swift_Message('Message envoyé depuis le site "une pause"'))
            ->setFrom($emailMessage->getEmail())
            ->setTo($parameters['email'])
            ->setBody(
                $this->renderView(
                    'contact/emailMessage.html.twig',
                    ['email_message' => $emailMessage,]
                ),
                'text/html'
            );
            $send = $mailer->send($message);
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

<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use App\Entity\Article;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(ObjectManager $manager, Request $request,  Swift_Mailer $mailer)
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
        ]);
    }
}

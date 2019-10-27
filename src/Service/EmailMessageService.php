<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
//use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;



class EmailMessageService
{
    private $requestStack;
    private $templating;
    private $mailer;


    public function __construct(RequestStack $requestStack, EngineInterface $templating, Swift_Mailer $mailer)
    {
        $this->requestStack = $requestStack;
        $this->templating = $templating;
        $this->mailer = $mailer;
    }

    public function sendMessage($form)
    {
            dump($form->getData());
            dump($this->requestStack->getCurrentRequest());
            $emailMessage = $form->getData();
            $parameters = $this->requestStack->getCurrentRequest()->get('parameters');
            $message = (new Swift_Message('Message envoyé depuis le site "une pause"'))
            ->setFrom($emailMessage->getEmail())
            ->setTo($parameters['email'])
            ->setBody(
                $this->templating->render(
                    'contact/emailMessage.html.twig',
                    ['email_message' => $emailMessage,]
                ),
                'text/html'
            );
            $send = $this->mailer->send($message);
        
    }



}
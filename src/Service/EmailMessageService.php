<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
//use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Service\ParameterService;



class EmailMessageService
{
    private $requestStack;
    private $templating;
    private $mailer;
    private $parameter;


    public function __construct(RequestStack $requestStack, EngineInterface $templating, Swift_Mailer $mailer, ParameterService $parameter)
    {
        $this->requestStack = $requestStack;
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->parameter = $parameter;
    }

    public function sendMessage($form)
    {
            dump($form->getData());
            dump($this->requestStack->getCurrentRequest());
            $emailMessage = $form->getData();
            $parameters = $this->requestStack->getCurrentRequest()->get('parameters');
            $message = (new Swift_Message('Message envoyé depuis le site "une pause"'))
            ->setFrom($emailMessage->getEmail())
            ->setTo($parameter->getEmail())
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
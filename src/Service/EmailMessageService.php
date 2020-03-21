<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
//use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Booking;
use App\Entity\Product;
use App\Service\ParameterService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;



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
        $emailMessage = $form->getData();
        $message = (new Swift_Message('Message envoyé depuis le site '.$this->parameter->getCompany()))
        ->setFrom($emailMessage->getEmail())
        ->setTo($this->parameter->getEmail())
        ->setBody(
            $this->templating->render(
                'contact/emailMessage.html.twig',
                ['email_message' => $emailMessage,]
            ),
            'text/html'
        );
        $send = $this->mailer->send($message);
        
    }

    public function sendBookingConfirmation($booking)
    {
        $mails = [
            ['recipient' => 'user', 'to' => (null !== $booking->getUser()) ? $booking->getUser()->getEmail() : $booking->getEmail()],
            ['recipient' => 'company', 'to' => $this->parameter->getEmail()]
        ];

        foreach($mails as $mail) {
            $message = (new Swift_Message('Message envoyé depuis le site '.$this->parameter->getCompany()))
                ->setFrom($this->parameter->getEmail())
                ->setTo($mail['to'])
                ->setBody(
                    $this->templating->render(
                        'email/booking.html.twig',
                        [
                            'booking' => $booking,
                            'recipient' => $mail['recipient'],
                        ]
                    ),
                    'text/html'
                );
            $send = $this->mailer->send($message);
        }
        return $send;
    }

    public function sendConfirmation($data, $product = null)
    {
        $mails = [
            ['recipient' => 'user', 'to' => $data->getEmail()],
            ['recipient' => 'company', 'to' => $this->parameter->getEmail()]
        ];

        foreach($mails as $mail) {
            $message = (new Swift_Message('Message envoyé depuis le site '.$this->parameter->getCompany()))
                ->setFrom($this->parameter->getEmail())
                ->setTo($mail['to'])
                ->setBody(
                    $this->templating->render(
                        'email/contact.html.twig',
                        [
                            'data' => $data,
                            'product' => $product,
                            'recipient' => $mail['recipient'],
                        ]
                    ),
                    'text/html'
                );
            $send = $this->mailer->send($message);
        }
        return $send;
    }

}
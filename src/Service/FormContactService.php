<?php

namespace App\Service;

use App\Form\ContactType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\FormFactoryInterface;

class FormContactService
{
 
    private $form; 
 
    private $router;
 
    private $formFactory;
 
    public function __construct(UrlGeneratorInterface $router, FormFactoryInterface $formFactory) {
 
        $this->router = $router;
 
        $this->formFactory = $formFactory;
 
        $this->form = $this->formFactory->create(ContactType::class, null, [
            'attr' =>[
                'action' => $this->router->generate('send_message')
            ]
        ]);
    }
 
    public function getForm() {
        return $this->form;
    }
}
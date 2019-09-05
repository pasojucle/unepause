<?php

namespace App\EventSubscriber;

use App\Entity\Tab;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class NavSubscriber implements EventSubscriberInterface
{
    private $manager;
    private $router;

    public function __construct(ObjectManager $manager, RouterInterface $router)
    {
        $this->manager = $manager;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController (ControllerEvent $event) 
    {
        $tabs = $this->manager->getRepository(Tab::class)->findAll();
        $event->getRequest()->request->set('tabs', $tabs);
    }
}
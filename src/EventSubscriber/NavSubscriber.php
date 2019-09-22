<?php

namespace App\EventSubscriber;

use App\Entity\Container;
use App\Entity\Parameter;
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
        $containers = $this->manager->getRepository(Container::class)->findAll();
        foreach($containers as $container) {
            if (Container::NAV_ID == $container->getId()) {
                $navActions = $container->getActions()->toArray();
            }
            if (Container::FOOTER_ID == $container->getId()) {
                $footerActions = $container->getActions()->toArray();
            }
        }
        $event->getRequest()->request->set('nav_actions', $navActions);
        $event->getRequest()->request->set('footer_actions', $footerActions);

        $parameters = $this->manager->getRepository(Parameter::class)->findAll();
        $parametersArray = [];
        foreach ($parameters as $parameter) {
            $parametersArray[$parameter->getName()] = $parameter->getValue();
        }
        $event->getRequest()->request->set('parameters', $parametersArray);
    }
}
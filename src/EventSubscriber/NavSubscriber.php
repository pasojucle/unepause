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
        $containers = $this->manager->getRepository(Container::class)->findAllContainers()
        ->getQuery()
        ->getResult();
        $navActions = null;
        $footerActions = null;
        $actions = [];
        foreach($containers as $container) {
            if (Container::NAV_ID == $container->getId()) {
                $navActions = $container->getActions()->toArray();
            }
            if (Container::FOOTER_ID == $container->getId()) {
                $footerActions = $container->getActions()->toArray();
            }
            $actions[$container->getTagName()] = $container->getActions()->toArray();
        }
        $event->getRequest()->request->set('nav_actions', $navActions);
        $event->getRequest()->request->set('footer_actions', $footerActions);
        //$event->getRequest()->request->set('actions', $actions);

        $parameters = $this->manager->getRepository(Parameter::class)->findAll();
        $parametersArray = [];
        foreach ($parameters as $parameter) {
            $parametersArray[$parameter->getName()] = $parameter->getValue();
            if ('company' == $parameter->getName()) {
                $value = preg_replace_callback('/\s(.?)/',function($matches) {return strtoupper(ltrim($matches[0]));}, strtolower($parameter->getValue()));
                $parametersArray['lowerCamelcase'] = $value;
                $value = preg_replace('/\s/','-', strtolower($parameter->getValue()));
                $parametersArray['dashCase'] = $value;
            }
        }
        //$event->getRequest()->request->set('parameters', $parametersArray);

        $containerClass = "winter";
        $event->getRequest()->request->set('containerClass', $containerClass);

    }
}
<?php

namespace App\EventSubscriber;

use App\Entity\Action;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NavSubscriber implements EventSubscriberInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
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
        $allActions = $this->manager->getRepository(Action::class)->findBy([],['parent'=> 'ASC', 'id'=> 'ASC']);

        $actions = [];
        foreach ($allActions as $action) {
            $parent = $action->getParent();
            $actionId = $action->getId();
            if (null == $parent) {
                $actions[$actionId] = [
                    'children' => [],
                    'parent' => $action,
                ];
            } else {
                $parentId = $parent->getId();
                if (array_key_exists($parentId,$actions)) {
                    $actions[$parentId]['children'][] = $action;
                }
            } 
        }
        $event->getRequest()->request->set('actions', $actions);
    }
}
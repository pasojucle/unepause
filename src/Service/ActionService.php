<?php

namespace App\Service;

use App\Entity\Action;
use App\Entity\Container;
use Doctrine\Common\Persistence\ObjectManager;

class ActionService
{
    private $manager;
    private $actions;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

        $containers = $this->manager->getRepository(Container::class)->findAllContainers()
        ->getQuery()
        ->getResult();

        $this->frontActions = $this->manager->getRepository(Action::class)->findFrontActions();

        $this->actions = [];
        foreach($containers as $container) {
            $this->actions[$container->getTagName()] = $container->getActions()->toArray();
        }
    }

    public function getFrontActions() {
        return $this->frontActions;
    }

    public function getHeaderActions() {
        return $this->actions['header'];
    }

    public function getFooterActions() {
        return $this->actions['footer'];
    }
}
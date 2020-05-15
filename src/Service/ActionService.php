<?php

namespace App\Service;

use App\Entity\Action;
use App\Entity\Container;
use Doctrine\ORM\EntityManagerInterface;

class ActionService
{
    private $manager;
    private $actions;

    public function __construct(EntityManagerInterface $manager)
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
        if (isset($this->actions['header'])) {
            return $this->actions['header'];
        }

        return [];
    }

    public function getFooterActions() {
        if (isset($this->actions['footer'])) {
            return $this->actions['footer'];
        }

        return [];
    }
}
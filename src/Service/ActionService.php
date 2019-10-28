<?php

namespace App\Service;

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
        $this->actions = [];
        foreach($containers as $container) {
            $this->actions[$container->getTagName()] = $container->getActions()->toArray();
        }
    }

    public function getHeaderActions() {
        return $this->actions['header'];
    }

    public function getFooterActions() {
        return $this->actions['footer'];
    }
}
<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class AppExtension extends AbstractExtension
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('isRoute', [$this, 'isRoute']),
        ];
    }

    public function isRoute($routeName)
    {
        try {
            $url = $this->router->generate($routeName);
        } catch (RouteNotFoundException $e) {
            return null;
        }

        return $url;
    }
}
<?php
namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('sortArticles', [$this, 'sortArticles']),
        ];
    }

public function sortArticles($pageContainer)
    {
        dump($articles);

        return $articles;
    }
}

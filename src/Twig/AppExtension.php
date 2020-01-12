<?php
namespace App\Twig;

use Twig\TwigTest;
use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('sortArticles', [$this, 'sortArticles']),
        ];
    }
    public function getTests()
    {
        return [
            new TwigTest('instanceof', [$this, 'instanceof']),
        ];
    }

    public function sortArticles($pageContainer)
    {
        dump($articles);

        return $articles;
    }

    public function instanceof($var, $instance)
    {
        return $var instanceof $instance;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('encodeImg', [$this, 'encodeImg']),
        ];
    }

    public function encodeImg(string $filename)
    {
        return base64_encode(file_get_contents($filename));
    }
}

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
            new TwigFunction('unserialize', [$this, 'unserialize']),
        ];
    }

    public function encodeImg(string $filename)
    {
        return base64_encode(file_get_contents($filename));
    }

    public function unserialize(string $value):array
    {
        return unserialize($value);
    }
}

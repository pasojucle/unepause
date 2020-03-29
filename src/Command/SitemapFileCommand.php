<?php

namespace App\Command;

use App\Service\ActionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapFileCommand extends Command
{
    protected static $defaultName = 'make:sitemap:file';

    private $actionService;
    private $router;

    public function __construct(ActionService $actionService, UrlGeneratorInterface $router)
    {
        parent::__construct();
        $this->actionService = $actionService;
        $this->router = $router;
    }

    protected function configure()
    {
        $this
            ->setDescription('Make sitemap file')
            ->addArgument('publicDir', InputArgument::REQUIRED, 'public dir')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $publicDir = $input->getArgument('publicDir');
        $actions = $this->actionService->getFrontActions();
        $mainNode = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        foreach($actions as $action) {
            if ($action->getIsActive() == 1) {
                foreach ($action->getPages() as $page) {
                    if ($page->getIsActive() == 1) {
                        
                        $route = $page->getTemplate()->getRoute();
                        $parameters = [];
                        if (null != $route->getParameters()) {
                            $parameters['actionSlug'] = $action->getSlug();
                            if ($page->getSlug() != $action->getSlug()) {
                                $parameters['pageSlug'] = $page->getSlug();
                            }
                        }
                        $rN = $mainNode->addChild('url');
                        $rN->addChild('loc', $this->router->generate($route->getName(), $parameters, UrlGeneratorInterface::ABSOLUTE_URL));
                    }
                }
            }          
        }
        $mainNode->asXML($publicDir.DIRECTORY_SEPARATOR.'sitemap.xml');

        $io->success('Sitemap file is created');

        return 0;
    }
}

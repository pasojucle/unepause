<?php

namespace App\Command;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RobotsFileCommand extends Command
{
    protected static $defaultName = 'make:robots:file';

    private $requestContext;
    
    public function __construct(RequestContext $requestContext)
    {
        parent::__construct();
        $this->requestContext = $requestContext;
        
    }
    protected function configure()
    {
        $this
        ->setDescription('Make robots file')
        ->addArgument('publicDir', InputArgument::REQUIRED, 'public dir')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $publicDir = $input->getArgument('publicDir');

        $content = "User-agent : *\n"
                . "\n"
                . "Sitemap : ".$this->requestContext->getScheme()."://".$this->requestContext->getHost()."/sitemap.xml"
                ;
        // Écrit le résultat dans le fichier
        file_put_contents($publicDir.DIRECTORY_SEPARATOR.'robots.txt', $content);

        $io->success('Robots file is created');

        return 0;
    }
}

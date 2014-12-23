<?php

namespace Behat\Borg\Application\DocumentationBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateDocumentationCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('doc:build')
            ->setDescription('Builds all registered documentation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}

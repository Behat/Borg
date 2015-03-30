<?php

namespace Behat\Borg\Integration\Symfony\Release\Command;

use Behat\Borg\Integration\Release\GitHub\GitHubRepository;
use Behat\Borg\Release\Version;
use Behat\Borg\ReleaseManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ReleaseCommand extends Command
{
    private $manager;

    public function __construct(ReleaseManager $manager)
    {
        $this->manager = $manager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('release')
            ->addArgument('package')
            ->addArgument('version')
            ->setDescription('Builds all registered documentation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->manager->release(
            GitHubRepository::named($input->getArgument('package')),
            Version::string($input->getArgument('version'))
        );
    }
}

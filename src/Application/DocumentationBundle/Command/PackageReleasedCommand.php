<?php

namespace Behat\Borg\Application\DocumentationBundle\Command;

use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Behat\Borg\ReleaseManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PackageReleasedCommand extends Command
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
            ->setName('package:released')
            ->addArgument('package')
            ->addArgument('version')
            ->setDescription('Builds all registered documentation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $aPackage = GitHubPackage::named($input->getArgument('package'));
        $version = Version::string($input->getArgument('version'));
        $aRelease = new Release($aPackage, $version);

        $this->manager->release($aRelease);
    }
}

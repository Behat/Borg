<?php

namespace Smoke;

use Behat\Behat\Context\Context;
use Behat\Borg\Release\Repository;
use Behat\Borg\Release\Version;
use PHPUnit_Framework_Assert as PHPUnit;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Transformation;

/**
 * Defines application features from the specific context.
 */
class ReleaseUIContext implements Context
{
    use Transformation\Release;

    /**
     * @BeforeScenario
     */
    public function cleanBuildAndWebFolders()
    {
        $cacheDir = __DIR__ . '/../../app/cache/test';
        (new Filesystem())->remove(["{$cacheDir}/build", "{$cacheDir}/docs"]);
    }

    /**
     * @When I release :repository version :version
     */
    public function iReleaseRelease(Repository $repository, Version $version)
    {
        $process = new Process($this->releaseCommand($repository, $version));
        $process->run();

        PHPUnit::assertTrue($process->isSuccessful(), "{$process->getOutput()}\n{$process->getErrorOutput()}");
    }

    private function releaseCommand(Repository $repository, Version $version)
    {
        return __DIR__ . "/../../app/console release {$repository} {$version} -e=test";
    }
}

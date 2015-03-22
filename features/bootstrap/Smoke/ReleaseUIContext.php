<?php

namespace Smoke;

use Behat\Behat\Context\Context;
use PHPUnit_Framework_Assert as PHPUnit;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Transformation;

/**
 * Defines application features from the specific context.
 */
class ReleaseUIContext implements Context
{
    /**
     * @BeforeScenario
     */
    public function cleanBuildAndWebFolders()
    {
        $cacheDir = __DIR__ . '/../../../app/cache/test';
        (new Filesystem())->remove(["{$cacheDir}/build", "{$cacheDir}/docs"]);
    }

    /**
     * @When I release :repository version :version
     */
    public function iReleaseRelease($repository, $version)
    {
        $process = new Process($this->releaseCommand($repository, $version));
        $process->run();

        PHPUnit::assertTrue($process->isSuccessful(), "{$process->getOutput()}\n{$process->getErrorOutput()}");
    }

    private function releaseCommand($repository, $version)
    {
        return __DIR__ . "/../../../app/console release {$repository} {$version} -e=test";
    }
}

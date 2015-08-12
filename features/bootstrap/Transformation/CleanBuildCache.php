<?php

namespace Transformation;

use Symfony\Component\Filesystem\Filesystem;

trait CleanBuildCache
{
    /**
     * @BeforeScenario
     */
    public function cleanBuildAndWebFolders()
    {
        (new Filesystem())->remove(__DIR__ . '/../../../app/cache/test/build');
    }
}

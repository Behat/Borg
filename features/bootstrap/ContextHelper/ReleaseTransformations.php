<?php

namespace ContextHelper;

use Behat\Borg\Release\Version;
use Fake\Package\FakePackage;
use Fake\Release\FakeRepository;

trait ReleaseTransformations
{
    private $scenarioRepositories = [];

    /**
     * @Transform :repository
     */
    public function transformStringToRepository($string)
    {
        return $this->scenarioRepositories[$string] = isset($this->scenarioRepositories[$string])
            ? $this->scenarioRepositories[$string]
            : FakeRepository::named($string);
    }

    /**
     * @Transform :package
     */
    public function transformStringToPackage($string)
    {
        return FakePackage::named($string);
    }

    /**
     * @Transform :version
     */
    public function transformStringToVersion($string)
    {
        return Version::string($string);
    }
}

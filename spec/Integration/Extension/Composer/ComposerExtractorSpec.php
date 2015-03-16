<?php

namespace spec\Behat\Borg\Integration\Extension\Composer;

use Behat\Borg\Extension\Extractor\Extractor;
use Behat\Borg\Integration\Release\Composer\ComposerPackage;
use Behat\Borg\Release\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComposerExtractorSpec extends ObjectBehavior
{
    function it_is_extension_extractor()
    {
        $this->shouldHaveType(Extractor::class);
    }

    function it_extracts_nothing_if_provided_package_is_not_a_composer_package(Package $package)
    {
        $this->extract($package)->shouldReturn(null);
    }

    function it_extracts_nothing_if_provided_composer_package_is_not_of_type_behat_extension()
    {
        $package = new ComposerPackage([
            'name' => 'behat/behat',
            'type' => 'library'
        ]);

        $this->extract($package)->shouldReturn(null);
    }
}

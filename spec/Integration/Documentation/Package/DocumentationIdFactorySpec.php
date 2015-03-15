<?php

namespace spec\Behat\Borg\Integration\Documentation\Package;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentationIdFactorySpec extends ObjectBehavior
{
    function let(Package $package)
    {
        $package->__toString()->willReturn('behat/behat');
    }

    function it_creates_documentation_id_using_provided_package_and_version(Package $package)
    {
        $this->createDocumentationId($package, Version::string('v1.0.2'))->shouldBeLike(
            new DocumentationId('behat/behat', 'v1.0')
        );
    }

    function it_uses_minor_version_plus_x_as_a_version_string_for_unstable_packages(Package $package)
    {
        $this->createDocumentationId($package, Version::string('v1.0.x'))->shouldBeLike(
            new DocumentationId('behat/behat', 'v1.0.x')
        );
    }

    function it_uses_branch_name_as_a_version_string_for_branch_based_versions(Package $package)
    {
        $this->createDocumentationId($package, Version::string('master'))->shouldBeLike(
            new DocumentationId('behat/behat', 'master')
        );
    }
}

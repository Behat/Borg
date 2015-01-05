<?php

namespace spec\Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PackageDocumentationIdSpec extends ObjectBehavior
{
    function let(Package $package)
    {
        $package->__toString()->willReturn('behat/behat');

        $this->beConstructedWith($package, Version::string('v1.0.2'));
    }

    function it_is_a_documentation_identifier()
    {
        $this->shouldHaveType(DocumentationId::class);
    }

    function it_uses_package_name_as_a_project_name()
    {
        $this->getProjectName()->shouldReturn('behat/behat');
    }

    function it_uses_minor_version_as_a_version_string_for_stable_packages()
    {
        $this->getVersionString()->shouldReturn('v1.0');
    }

    function it_uses_minor_version_plus_x_as_a_version_string_for_unstable_packages(Package $package)
    {
        $this->beConstructedWith($package, Version::string('v1.0.x'));

        $this->getVersionString()->shouldReturn('v1.0.x');
    }

    function it_uses_branch_name_as_a_version_string_for_branch_based_versions(Package $package)
    {
        $this->beConstructedWith($package, Version::string('master'));

        $this->getVersionString()->shouldReturn('master');
    }

    function it_can_be_converted_to_a_string_combining_both_package_name_and_its_version_minor()
    {
        $this->__toString()->shouldReturn('behat/behat/v1.0');
    }
}

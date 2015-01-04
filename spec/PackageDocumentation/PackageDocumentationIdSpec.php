<?php

namespace spec\Behat\Borg\PackageDocumentation;

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

    function it_uses_minor_version_as_a_version_string()
    {
        $this->getVersionString()->shouldReturn('v1.0');
    }

    function it_can_be_converted_to_a_string_combining_both_package_name_and_its_version_minor()
    {
        $this->__toString()->shouldReturn('behat/behat/v1.0');
    }
}

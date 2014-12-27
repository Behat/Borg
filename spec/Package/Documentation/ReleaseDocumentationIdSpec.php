<?php

namespace spec\Behat\Borg\Package\Documentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseDocumentationIdSpec extends ObjectBehavior
{
    function let(Package $package)
    {
        $package->__toString()->willReturn('behat');

        $this->beConstructedWith(new Release($package->getWrappedObject(), Version::string('1.0.0')));
    }

    function it_is_a_documentation_identifier()
    {
        $this->shouldHaveType(DocumentationId::class);
    }

    function it_can_be_converted_to_a_string_combining_both_package_name_and_its_version()
    {
        $this->__toString()->shouldReturn('behat/1.0.0');
    }

    function it_uses_package_name_as_a_project_name()
    {
        $this->getProjectName()->shouldReturn('behat');
    }

    function it_uses_version_as_a_version_string()
    {
        $this->getVersionString()->shouldReturn('1.0.0');
    }

    function it_holds_a_release_reference(Package $package)
    {
        $this->getRelease()->shouldBeLike(
            new Release($package->getWrappedObject(), Version::string('1.0.0'))
        );
    }
}

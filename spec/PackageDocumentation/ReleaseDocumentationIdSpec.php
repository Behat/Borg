<?php

namespace spec\Behat\Borg\PackageDocumentation;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Release\Package;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
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

    function it_can_be_converted_to_a_string_combining_both_package_name_and_its_version_minor()
    {
        $this->__toString()->shouldReturn('behat/v1.0');
    }

    function it_uses_package_name_as_a_project_name()
    {
        $this->getProjectName()->shouldReturn('behat');
    }

    function it_tableize_package_name_into_a_project_name(Package $package)
    {
        $package->__toString()->willReturn('Behat/Symfony2Extension');

        $this->getProjectName()->shouldReturn('behat/symfony2-extension');
    }

    function it_uses_version_as_a_version_string()
    {
        $this->getVersionString()->shouldReturn('v1.0');
    }

    function it_holds_a_release_reference(Package $package)
    {
        $this->getRelease()->shouldBeLike(
            new Release($package->getWrappedObject(), Version::string('1.0.0'))
        );
    }
}

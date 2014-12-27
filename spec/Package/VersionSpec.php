<?php

namespace spec\Behat\Borg\Package;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VersionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('string', ['1.2.3-rc1']);
    }

    function it_can_be_created_using_semantic_version_string()
    {
        $this->shouldNotThrow()->during('string', ['1.0.0']);
        $this->shouldNotThrow()->during('string', ['v1.0.0']);
    }

    function it_can_be_created_using_short_version_string()
    {
        $this->shouldNotThrow()->during('string', ['1.0']);
        $this->shouldNotThrow()->during('string', ['v1.0']);
    }

    function it_can_be_created_using_RC_and_beta_version_strings()
    {
        $this->shouldNotThrow()->during('string', ['1.0.0-RC1']);
        $this->shouldNotThrow()->during('string', ['v2.0.0-rc.2']);
        $this->shouldNotThrow()->during('string', ['v1.0.0-beta']);
    }

    function it_can_not_be_created_using_anything_but_a_proper_version_string()
    {
        $this->shouldThrow()->during('string', ['master']);
    }

    function it_can_represent_a_major_version()
    {
        $this->getMajor()->shouldReturn('1');
    }

    function it_can_represent_a_minor_version()
    {
        $this->getMinor()->shouldReturn('1.2');
    }

    function it_can_represent_a_patch_version()
    {
        $this->getPatch()->shouldReturn('1.2.3-rc1');
    }

    function it_can_represent_canonical_SemVer()
    {
        $this->getSemVer()->shouldReturn('v1.2.3-rc1');
    }

    function it_can_present_minor_version_even_if_it_is_prefixed()
    {
        $this->beConstructedThrough('string', ['v1.2.3']);

        $this->getMinor()->shouldReturn('1.2');
    }

    function it_can_be_converted_to_that_string_later()
    {
        $this->__toString()->shouldReturn('1.2.3-rc1');
    }
}

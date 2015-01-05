<?php

namespace spec\Behat\Borg\Release;

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

    function it_can_be_created_using_develop_version_string()
    {
        $this->shouldNotThrow()->during('string', ['1.2.x']);
    }

    function it_can_be_created_using_develop_or_master()
    {
        $this->shouldNotThrow()->during('string', ['master']);
        $this->shouldNotThrow()->during('string', ['develop']);
    }

    function it_can_not_be_created_using_anything_else()
    {
        $this->shouldThrow()->during('string', ['anything-else']);
    }

    function it_can_tell_if_it_is_stable()
    {
        $this->string('1.2.3-rc1')->isStable()->shouldBe(false);
        $this->string('1.2.x')->isStable()->shouldBe(false);
        $this->string('develop')->isStable()->shouldBe(false);
        $this->string('master')->isStable()->shouldBe(false);
        $this->string('1.2.3')->isStable()->shouldBe(true);
    }

    function it_can_tell_if_it_is_branch()
    {
        $this->string('develop')->isBranch()->shouldBe(true);
        $this->string('master')->isBranch()->shouldBe(true);
        $this->string('1.2.3')->isBranch()->shouldBe(false);
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

    function its_patch_version_is_x_if_no_patch_part_provided()
    {
        $this->beConstructedThrough('string', ['v1.2']);

        $this->getPatch()->shouldReturn('1.2.x');
    }

    function its_branch_name_should_be_a_branch_it_was_created_with()
    {
        $this->beConstructedThrough('string', ['develop']);

        $this->getBranchName()->shouldReturn('develop');
    }

    function its_major_minor_and_patch_are_nulls_if_it_is_a_branch_version()
    {
        $this->beConstructedThrough('string', ['develop']);

        $this->getMajor()->shouldReturn(null);
        $this->getMinor()->shouldReturn(null);
        $this->getPatch()->shouldReturn(null);
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

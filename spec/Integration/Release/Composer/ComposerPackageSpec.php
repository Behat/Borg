<?php

namespace spec\Behat\Borg\Integration\Release\Composer;

use Behat\Borg\Integration\Release\Composer\Author;
use Behat\Borg\Release\Package;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComposerPackageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            [
                'name'        => 'behat/docs',
                'description' => 'behat documentation',
                'authors'     => [
                    ['name' => 'Konstantin Kudryashov', 'email' => 'ever.zet@gmail.com'],
                    ['name' => 'Christophe Coevoet', 'email' => 'stof@notk.org']
                ]
            ]
        );
    }

    function it_is_a_package()
    {
        $this->shouldHaveType(Package::class);
    }

    function it_can_not_be_constructed_with_a_name_that_has_less_than_2_segments_in_it()
    {
        $this->shouldThrow()->during('__construct', [['name' => 'behat', 'type' => 'library']]);
    }

    function it_can_not_be_constructed_with_a_name_that_has_more_than_2_segments_in_it()
    {
        $this->shouldThrow()->during('__construct', [['name' => 'behat/docs/v2', 'type' => 'library']]);
    }

    function its_organisation_name_is_a_first_segment_of_the_composer_package_name()
    {
        $this->organisationName()->shouldReturn('behat');
    }

    function it_lowercases_provided_organisation_and_package_name()
    {
        $this->beConstructedWith(['name' => 'Behat/Docs', 'type' => 'library']);

        $this->organisationName()->shouldReturn('behat');
        $this->name()->shouldReturn('docs');
    }

    function its_name_is_a_second_segment_of_the_composer_package_name()
    {
        $this->name()->shouldReturn('docs');
    }

    function its_default_type_is_library()
    {
        $this->type()->shouldReturn('library');
    }

    function it_has_a_different_type_if_provided()
    {
        $this->beConstructedWith(
            [
                'name' => 'behat/docs',
                'type' => 'whatever'
            ]
        );

        $this->type()->shouldReturn('whatever');
    }

    function it_has_a_description()
    {
        $this->description()->shouldReturn('behat documentation');
    }

    function it_has_authors()
    {
        $this->authors()->shouldBeLike(
            [
                new Author('Konstantin Kudryashov', 'ever.zet@gmail.com'),
                new Author('Christophe Coevoet', 'stof@notk.org'),
            ]
        );
    }

    function its_primary_author_is_the_first_one()
    {
        $this->primaryAuthor()->shouldBeLike(new Author('Konstantin Kudryashov', 'ever.zet@gmail.com'));
    }

    function its_primary_author_is_null_if_none_authors_found()
    {
        $this->beConstructedWith(
            [
                'name'        => 'behat/docs',
                'type'        => 'library',
                'description' => 'behat documentation'
            ]
        );

        $this->primaryAuthor()->shouldReturn(null);
    }

    function its_string_representation_is_the_name_of_the_package()
    {
        $this->__toString()->shouldReturn('behat/docs');
    }
}

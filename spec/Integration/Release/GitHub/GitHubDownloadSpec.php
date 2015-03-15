<?php

namespace spec\Behat\Borg\Integration\Release\GitHub;

use Behat\Borg\Integration\Release\GitHub\Commit;
use Behat\Borg\Integration\Release\GitHub\GitHubRepository;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GitHubDownloadSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new Release(
                GitHubRepository::named('behat/docs'),
                Version::string('v2.5')
            ),
            Commit::committedWithShaAtTime(
                '839e5185da9434753db47959bee16642bb4f2ce4',
                new \DateTimeImmutable('2011-04-14T16:00:49Z')
            ),
            __DIR__
        );
    }

    function it_is_a_download()
    {
        $this->shouldHaveType(Download::class);
    }

    function it_holds_a_commit()
    {
        $this->commit()->shouldBeLike(
            Commit::committedWithShaAtTime(
                '839e5185da9434753db47959bee16642bb4f2ce4',
                new \DateTimeImmutable('2011-04-14T16:00:49Z')
            )
        );
    }

    function its_release_time_is_a_time_of_the_commit()
    {
        $this->releasedAt()->shouldBeLike(new \DateTimeImmutable('2011-04-14T16:00:49Z'));
    }

    function its_version_is_the_release_version()
    {
        $this->version()->shouldBeLike(Version::string('v2.5'));
    }

    function its_path_is_the_path_it_was_constructed_with()
    {
        $this->path()->shouldReturn(__DIR__);
    }

    function it_could_say_if_given_file_is_included_in_the_release()
    {
        $this->shouldHaveFile(basename(__FILE__));
        $this->shouldNotHaveFile('any_file');
    }

    function it_could_provide_an_absolute_path_to_the_file_using_relative_one()
    {
        $this->filePath(basename(__FILE__))->shouldReturn(__FILE__);
    }

    function it_should_throw_an_exception_when_trying_to_get_path_for_inexistent_file()
    {
        $this->shouldThrow()->duringFilePath('any_file');
    }
}

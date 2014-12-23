<?php

namespace spec\Behat\Borg\GitHub;

use Behat\Borg\GitHub\Commit;
use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommittedReleaseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new Release(
                GitHubPackage::named('behat/docs'),
                Version::string('v2.5')
            ),
            Commit::committedWithShaAt(
                '839e5185da9434753db47959bee16642bb4f2ce4',
                new \DateTimeImmutable('2011-04-14T16:00:49Z')
            )
        );
    }

    function it_holds_a_release()
    {
        $this->getRelease()->shouldBeLike(
            new Release(
                GitHubPackage::named('behat/docs'),
                Version::string('v2.5')
            )
        );
    }

    function it_holds_a_commit()
    {
        $this->getCommit()->shouldBeLike(
            Commit::committedWithShaAt(
                '839e5185da9434753db47959bee16642bb4f2ce4',
                new \DateTimeImmutable('2011-04-14T16:00:49Z')
            )
        );
    }
}

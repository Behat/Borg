<?php

namespace tests\Behat\Borg\GitHub;

use Behat\Borg\GitHub\Commit;
use Behat\Borg\GitHub\CommittedRelease;
use Behat\Borg\GitHub\GitHubBranchReleaseDownloader;
use Behat\Borg\GitHub\GitHubPackage;
use Behat\Borg\Package\DownloadedRelease;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Github\Client;
use Github\HttpClient\CachedHttpClient;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Filesystem\Filesystem;

class GitHubBranchReleaseDownloaderTest extends PHPUnit_Framework_TestCase
{
    private $client;
    private $tempDownloadPath;
    private $downloader;

    protected function setUp()
    {
        $this->tempDownloadPath = getenv('TEMP_PATH') . '/github/download';
        $this->client = new Client();
        $this->client->authenticate(getenv('GITHUB_TOKEN'), null, Client::AUTH_URL_TOKEN);

        $this->downloader = new GitHubBranchReleaseDownloader(
            $this->client, $this->tempDownloadPath, ['Behat/docs']
        );

        (new Filesystem())->remove($this->tempDownloadPath);
    }

    /** @test */
    function it_can_download_a_specific_release_of_tracked_repository()
    {
        $release = new Release(GitHubPackage::named('Behat/docs'), Version::string('v3.0'));
        $releasePath = $this->tempDownloadPath . '/' . $release;

        $downloadedRelease = $this->downloader->downloadRelease($release);

        $this->assertInstanceOf(DownloadedRelease::class, $downloadedRelease);
        $this->assertFileExists($releasePath . '/index.rst');
        $this->assertEquals(
            $downloadedRelease->getCommit(),
            unserialize(file_get_contents("{$releasePath}/commit.meta"))
        );
    }

    /** @test */
    function it_replaces_existing_release_if_newer_commits_found()
    {
        $release = new Release(GitHubPackage::named('Behat/docs'), Version::string('v3.0'));
        $oldCommit = Commit::committedWithShaAt(
            'eda4feb1fb814faf3ab334c2b26b9e61eb7a3940',
            new \DateTimeImmutable('2014-05-10T12:35:02Z')
        );

        $releasePath = "{$this->tempDownloadPath}/{$release}";
        (new Filesystem())->mkdir($releasePath);
        file_put_contents("{$releasePath}/commit.meta", serialize($oldCommit));
        touch("{$releasePath}/some_file");

        $downloadedRelease = $this->downloader->downloadRelease($release);

        $this->assertNotEquals($oldCommit, $downloadedRelease->getCommit());
        $this->assertFileNotExists("{$releasePath}/some_file");
    }

    /** @test */
    function it_does_not_touch_existing_release_if_newer_commits_not_found()
    {
        $release = new Release(GitHubPackage::named('Behat/docs'), Version::string('v3.0'));
        $oldCommit = $this->getLatestCommit($release);

        $releasePath = "{$this->tempDownloadPath}/{$release}";
        (new Filesystem())->mkdir($releasePath);
        file_put_contents("{$releasePath}/commit.meta", serialize($oldCommit));
        touch("{$releasePath}/some_file");

        $downloadedRelease = $this->downloader->downloadRelease($release);

        $this->assertEquals($oldCommit, $downloadedRelease->getCommit());
        $this->assertFileExists("{$releasePath}/some_file");
    }

    /** @test @expectedException InvalidArgumentException */
    function it_throws_an_exception_when_trying_to_download_release_for_untracked_package()
    {
        $release = new Release(GitHubPackage::named('Behat/Behat'), Version::string('v3.0'));

        $this->downloader->downloadRelease($release);
    }

    /** @test */
    function it_can_download_all_releases_for_tracked_repositories()
    {
        $downloadedReleases = $this->downloader->downloadAllReleases();

        $release25 = new Release(GitHubPackage::named('Behat/docs'), Version::string('v2.5'));
        $release30 = new Release(GitHubPackage::named('Behat/docs'), Version::string('v3.0'));

        $this->assertContains(
            new CommittedRelease($release25, $this->getLatestCommit($release25)),
            $downloadedReleases,
            "Release 2.5 is not found",
            false,
            false
        );
        $this->assertContains(
            new CommittedRelease($release30, $this->getLatestCommit($release30)),
            $downloadedReleases,
            "Release 3.0 is not found",
            false,
            false
        );

        $this->assertFileExists("{$this->tempDownloadPath}/Behat/docs/v2.5/commit.meta");
        $this->assertFileExists("{$this->tempDownloadPath}/Behat/docs/v3.0/commit.meta");
    }

    private function getLatestCommit(Release $release)
    {
        $commit = $this->client->api('repo')->commits()->all(
            $release->getPackage()->getOrganisation(),
            $release->getPackage()->getName(),
            array('sha' => (string)$release->getVersion())
        )[0];

        $date = new \DateTimeImmutable($commit['commit']['author']['date']);

        return Commit::committedWithShaAt($commit['sha'], $date);
    }
}

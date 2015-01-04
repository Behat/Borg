<?php

namespace tests\Behat\Borg\GitHub;

use Behat\Borg\GitHub\Commit;
use Behat\Borg\GitHub\GitHubDownloader;
use Behat\Borg\GitHub\GitHubRepository;
use Behat\Borg\Release\Downloader\Download;
use Behat\Borg\Release\Release;
use Behat\Borg\Release\Version;
use Github\Client;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Filesystem\Filesystem;

class GitHubDownloaderTest extends PHPUnit_Framework_TestCase
{
    private $tempDownloadPath;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var GitHubDownloader
     */
    private $downloader;

    protected function setUp()
    {
        $this->tempDownloadPath = getenv('TEST_TEMP_PATH') . '/github/download';
        $this->client = new Client();
        $this->client->authenticate(getenv('TEST_GITHUB_TOKEN'), null, Client::AUTH_URL_TOKEN);
        $this->downloader = new GitHubDownloader($this->client, $this->tempDownloadPath);

        (new Filesystem())->remove($this->tempDownloadPath);
    }

    /** @test */
    function it_can_download_a_specific_release_of_tracked_repository()
    {
        $release = new Release(GitHubRepository::named('Behat/docs'), Version::string('v3.0'));
        $releasePath = $this->tempDownloadPath . '/' . $release;

        $downloadedRelease = $this->downloader->download($release);

        $this->assertInstanceOf(Download::class, $downloadedRelease);
        $this->assertFileExists($releasePath . '/index.rst');
        $this->assertEquals(
            $downloadedRelease->getCommit(),
            unserialize(file_get_contents("{$releasePath}/commit.meta"))
        );
    }

    /** @test */
    function it_replaces_existing_release_if_newer_commits_found()
    {
        $release = new Release(GitHubRepository::named('Behat/docs'), Version::string('v3.0'));
        $oldCommit = Commit::committedWithShaAtTime(
            'eda4feb1fb814faf3ab334c2b26b9e61eb7a3940',
            new \DateTimeImmutable('2014-05-10T12:35:02Z')
        );

        $releasePath = "{$this->tempDownloadPath}/{$release}";
        (new Filesystem())->mkdir($releasePath);
        file_put_contents("{$releasePath}/commit.meta", serialize($oldCommit));
        touch("{$releasePath}/some_file");

        $downloadedRelease = $this->downloader->download($release);

        $this->assertNotEquals($oldCommit, $downloadedRelease->getCommit());
        $this->assertFileNotExists("{$releasePath}/some_file");
    }

    /** @test */
    function it_does_not_touch_existing_release_if_newer_commits_not_found()
    {
        $release = new Release(GitHubRepository::named('Behat/docs'), Version::string('v3.0'));
        $oldCommit = $this->getLatestCommit($release);

        $releasePath = "{$this->tempDownloadPath}/{$release}";
        (new Filesystem())->mkdir($releasePath);
        file_put_contents("{$releasePath}/commit.meta", serialize($oldCommit));
        touch("{$releasePath}/some_file");

        $downloadedRelease = $this->downloader->download($release);

        $this->assertEquals($oldCommit, $downloadedRelease->getCommit());
        $this->assertFileExists("{$releasePath}/some_file");
    }

    /** @test @expectedException RuntimeException */
    function it_throws_an_exception_when_trying_to_download_nonexistent_release()
    {
        $release = new Release(GitHubRepository::named('Behat/Behat'), Version::string('v1.0'));

        $this->downloader->download($release);
    }

    private function getLatestCommit(Release $release)
    {
        $commit = $this->client->repo()->commits()->all(
            $release->getRepository()->getOrganisation(),
            $release->getRepository()->getName(),
            array('sha' => (string)$release->getVersion())
        )[0];

        $date = new \DateTimeImmutable($commit['commit']['author']['date']);

        return Commit::committedWithShaAtTime($commit['sha'], $date);
    }
}

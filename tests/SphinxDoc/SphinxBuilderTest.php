<?php

namespace tests\Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\Source;
use Behat\Borg\Package\Downloader\Download;
use Behat\Borg\Package\Package;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\Version;
use Behat\Borg\SphinxDoc\Rst;
use Behat\Borg\SphinxDoc\SphinxBuilder;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;

class SphinxBuilderTest extends PHPUnit_Framework_TestCase
{
    private $tempInputPath;
    private $tempOutputPath;
    private $builder;

    protected function setUp()
    {
        $this->tempInputPath = getenv('TEMP_PATH') . '/sphinx/input';
        $this->tempOutputPath = getenv('TEMP_PATH') . '/sphinx/output';
        $this->builder = new SphinxBuilder($this->tempOutputPath, realpath(__DIR__ . '/../../sphinx'), new Filesystem());

        (new Filesystem())->remove([$this->tempInputPath, $this->tempOutputPath]);
    }

    /** @test @expectedException InvalidArgumentException */
    function it_throws_an_exception_if_non_RST_documentation_provided()
    {
        $download = $this->createDownload('my/doc', '1.3.5');
        $source = $this->createDocumentationSource();
        $documentation = Documentation::downloaded($download, $source);

        $this->builder->buildDocumentation($documentation);
    }

    /** @test */
    function it_builds_RST_documentation_into_the_output_path()
    {
        $download = $this->createDownload('my/doc', 'v1.3.5');
        $source = $this->createRstDocumentationSourceWithIndex("Docs\n====");
        $documentation = Documentation::downloaded($download, $source);

        $built = $this->builder->buildDocumentation($documentation);

        $this->assertFileExists($this->tempOutputPath . '/my/doc/v1.3/index.html');
        $this->assertEquals(
            $this->tempOutputPath . '/my/doc/v1.3/index.html', $built->getIndexPath()
        );

        $this->assertContains('<h1>Docs', file_get_contents($built->getIndexPath()));
        $this->assertContains('my/doc', file_get_contents($built->getIndexPath()));
        $this->assertContains('v1.3', file_get_contents($built->getIndexPath()));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    function it_throws_an_exception_if_sphinx_can_not_build_documents()
    {
        $download = $this->createDownload('my/doc', '1.3.5');
        $source = $this->createRstDocumentationSourceWithoutIndex();
        $documentation = Documentation::downloaded($download, $source);

        $this->builder->buildDocumentation($documentation);
    }

    /**
     * @param string $packageName
     * @param string $version
     *
     * @return Download
     */
    private function createDownload($packageName, $version)
    {
        $package = $this->getMock(Package::class);
        $package->method('__toString')->willReturn($packageName);

        $download = $this->getMock(Download::class);
        $download->method('getRelease')->willReturn(
            $release = new Release($package, Version::string($version))
        );
        $download->method('getReleaseTime')->willReturn(new DateTimeImmutable());

        return $download;
    }

    /**
     * @return Source
     */
    private function createDocumentationSource()
    {
        return $this->getMock(Source::class);
    }

    /**
     * @param string $content
     *
     * @return Rst
     */
    private function createRstDocumentationSourceWithIndex($content)
    {
        (new Filesystem())->dumpFile($this->tempInputPath . '/index.rst', $content);

        return Rst::atPath($this->tempInputPath);
    }

    /**
     * @return Rst
     */
    private function createRstDocumentationSourceWithoutIndex()
    {
        return Rst::atPath($this->tempInputPath);
    }
}

<?php

namespace tests\Behat\Borg\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\DocumentationDirectoryPublisher;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DocumentationDirectoryPublisherTest extends PHPUnit_Framework_TestCase
{
    private $tempBuildPath;
    private $tempPublishPath;
    private $publisher;

    protected function setUp()
    {
        $this->tempBuildPath = getenv('TEMP_PATH') . '/github/publisher/build';
        $this->tempPublishPath = getenv('TEMP_PATH') . '/github/publisher/publish';

        $this->publisher = new DocumentationDirectoryPublisher($this->tempPublishPath);

        (new Filesystem())->remove([$this->tempBuildPath, $this->tempPublishPath]);
    }

    /** @test */
    function it_publishes_documentation_by_moving_it_to_appropriate_folder()
    {
        $anId = $this->getMock(DocumentationId::class);
        $anId->method('__toString')->willReturn('built_doc');
        $builtDoc = $this->getMock(BuiltDocumentation::class);
        $builtDoc->method('getId')->willReturn($anId);
        $builtDoc->method('getBuildPath')->willReturn($this->tempBuildPath . '/built_doc');

        (new Filesystem())->mkdir($this->tempBuildPath . '/built_doc');
        (new Filesystem())->touch($this->tempBuildPath . '/built_doc/my_file');

        $publishedDoc = $this->publisher->publishDocumentation($builtDoc);

        $this->assertEquals(
            PublishedDocumentation::publish($builtDoc, $this->tempPublishPath . '/built_doc'),
            $publishedDoc
        );
        $this->assertFileExists($this->tempPublishPath . '/built_doc/my_file');
        $this->assertEquals($publishedDoc, unserialize(file_get_contents(
            $this->tempPublishPath . '/built_doc/publish.meta'
        )));
    }

    /** @test */
    function it_can_check_if_documentation_was_published()
    {
        $anId = $this->getMock(DocumentationId::class);
        $anId->method('__toString')->willReturn('my_doc');
        $builtDoc = $this->getMock(BuiltDocumentation::class);
        $publishedDoc = PublishedDocumentation::publish($builtDoc, $this->tempPublishPath . '/my_doc');

        (new Filesystem())->mkdir($this->tempPublishPath . '/my_doc');
        file_put_contents($this->tempPublishPath . '/my_doc/publish.meta', serialize($publishedDoc));

        $this->assertTrue($this->publisher->hasPublishedDocumentation($anId));
        $this->assertFalse($this->publisher->hasPublishedDocumentation($this->getMock(DocumentationId::class)));
    }

    /** @test */
    function it_can_get_published_documentation()
    {
        $anId = $this->getMock(DocumentationId::class);
        $anId->method('__toString')->willReturn('my_doc');
        $builtDoc = $this->getMock(BuiltDocumentation::class);
        $publishedDoc = PublishedDocumentation::publish(
            $builtDoc, $this->tempPublishPath . '/my_doc'
        );

        (new Filesystem())->mkdir($this->tempPublishPath . '/my_doc');
        file_put_contents(
            $this->tempPublishPath . '/my_doc/publish.meta', serialize($publishedDoc)
        );

        $this->assertEquals($publishedDoc, $this->publisher->getPublishedDocumentation($anId));
    }

    /** @test @expectedException InvalidArgumentException */
    function it_throws_an_exception_when_trying_to_get_unpublished_documentation()
    {
        $this->publisher->getPublishedDocumentation($this->getMock(DocumentationId::class));
    }
}

<?php

namespace tests\Behat\Borg\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\DirectoryPublisher;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DirectoryPublisherTest extends PHPUnit_Framework_TestCase
{
    private $tempBuildPath;
    private $tempPublishPath;
    /**
     * @var DirectoryPublisher
     */
    private $publisher;

    protected function setUp()
    {
        $this->tempBuildPath = getenv('TEST_TEMP_PATH') . '/github/publisher/build';
        $this->tempPublishPath = getenv('TEST_TEMP_PATH') . '/github/publisher/publish';
        $this->publisher = new DirectoryPublisher($this->tempPublishPath);

        (new Filesystem())->remove([$this->tempBuildPath, $this->tempPublishPath]);
    }

    /** @test */
    function it_publishes_documentation_by_moving_it_to_appropriate_folder()
    {
        $anId = $this->getMock(DocumentationId::class);
        $anId->method('__toString')->willReturn('built_doc');
        $builtDoc = $this->getMock(BuiltDocumentation::class);
        $builtDoc->method('documentationId')->willReturn($anId);
        $builtDoc->method('buildPath')->willReturn($this->tempBuildPath . '/built_doc');

        (new Filesystem())->mkdir($this->tempBuildPath . '/built_doc');
        (new Filesystem())->touch($this->tempBuildPath . '/built_doc/my_file');

        $publishedDoc = $this->publisher->publish($builtDoc);

        $this->assertEquals(
            PublishedDocumentation::publish($builtDoc, $this->tempPublishPath . '/built_doc'),
            $publishedDoc
        );
    }
}

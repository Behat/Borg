<?php

namespace tests\Behat\Borg\Integration\Documentation\Filesystem;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Integration\Documentation\Filesystem\DirectoryPublisher;
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
        $anId = new DocumentationId('built_doc', 'v1.0');
        $builtDoc = $this->getMock(BuiltDocumentation::class);
        $builtDoc->method('documentationId')->willReturn($anId);
        $builtDoc->method('path')->willReturn($this->tempBuildPath . '/built_doc/v1.0');

        (new Filesystem())->mkdir($this->tempBuildPath . '/built_doc/v1.0');
        (new Filesystem())->touch($this->tempBuildPath . '/built_doc/v1.0/my_file');

        $publishedDoc = $this->publisher->publish($builtDoc);

        $this->assertEquals(
            PublishedDocumentation::publish($builtDoc, $this->tempPublishPath . '/built_doc/v1.0'),
            $publishedDoc
        );
    }
}

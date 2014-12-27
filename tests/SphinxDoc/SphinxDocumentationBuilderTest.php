<?php

namespace tests\Behat\Borg\SphinxDoc;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\SphinxDoc\RstDocumentationSource;
use Behat\Borg\SphinxDoc\SphinxDocumentationBuilder;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;

class SphinxDocumentationBuilderTest extends PHPUnit_Framework_TestCase
{
    private $tempInputPath;
    private $tempOutputPath;
    private $builder;

    protected function setUp()
    {
        $this->tempInputPath = getenv('TEMP_PATH') . '/sphinx/input';
        $this->tempOutputPath = getenv('TEMP_PATH') . '/sphinx/output';

        $this->builder = new SphinxDocumentationBuilder(
            $this->tempOutputPath, realpath(__DIR__ . '/../../sphinx'), new Filesystem()
        );

        (new Filesystem())->remove([$this->tempInputPath, $this->tempOutputPath]);
    }

    /** @test @expectedException InvalidArgumentException */
    function it_throws_an_exception_if_non_RST_documentation_provided()
    {
        $anId = $this->createDocumentationId('my/doc', '1.3.5');
        $source = $this->createDocumentationSource();
        $documentation = new Documentation($anId, $source, new DateTimeImmutable());

        $this->builder->build($documentation);
    }

    /** @test */
    function it_builds_RST_documentation_into_the_output_path()
    {
        $anId = $this->createDocumentationId('my/doc', 'v1.3.5');
        $source = $this->createRstDocumentationSourceWithIndex("Docs\n====");
        $documentation = new Documentation($anId, $source, new DateTimeImmutable());

        $built = $this->builder->build($documentation);

        $this->assertFileExists($this->tempOutputPath . '/my/doc/index.html');
        $this->assertEquals($this->tempOutputPath . '/my/doc/index.html', $built->getIndexPath());

        $this->assertContains('<h1>Docs', file_get_contents($built->getIndexPath()));
        $this->assertContains('my/doc', file_get_contents($built->getIndexPath()));
        $this->assertContains('v1.3.5', file_get_contents($built->getIndexPath()));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    function it_throws_an_exception_if_sphinx_can_not_build_documents()
    {
        $anId = $this->createDocumentationId('myDoc', '1.3.5');
        $source = $this->createRstDocumentationSourceWithoutIndex();
        $documentation = new Documentation($anId, $source, new DateTimeImmutable());

        $this->builder->build($documentation);
    }

    /**
     * @param string $id
     * @param string $version
     *
     * @return DocumentationId
     */
    private function createDocumentationId($id, $version)
    {
        $anId = $this->getMock(DocumentationId::class);
        $anId->method('__toString')->willReturn($id);
        $anId->method('getProjectName')->willReturn($id);
        $anId->method('getVersionString')->willReturn($version);

        return $anId;
    }

    /**
     * @return DocumentationSource
     */
    private function createDocumentationSource()
    {
        return $this->getMock(DocumentationSource::class);
    }

    /**
     * @param string $content
     *
     * @return RstDocumentationSource
     */
    private function createRstDocumentationSourceWithIndex($content)
    {
        (new Filesystem())->dumpFile($this->tempInputPath . '/index.rst', $content);

        return RstDocumentationSource::atPath($this->tempInputPath);
    }

    /**
     * @return RstDocumentationSource
     */
    private function createRstDocumentationSourceWithoutIndex()
    {
        return RstDocumentationSource::atPath($this->tempInputPath);
    }
}

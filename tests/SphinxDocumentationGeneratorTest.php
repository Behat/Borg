<?php

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\SphinxDoc\Documentation\RstDocumentationSource;
use Behat\Borg\SphinxDoc\DocumentationBuilder\Generator\SphinxDocumentationGenerator;
use Symfony\Component\Filesystem\Filesystem;

class SphinxDocumentationGeneratorTest extends PHPUnit_Framework_TestCase
{
    private $tempInputPath;
    private $tempOutputPath;
    private $generator;

    protected function setUp()
    {
        $this->tempInputPath = __DIR__ . '/../test_temp/phpunit_input';
        $this->tempOutputPath = __DIR__ . '/../test_temp/phpunit_output';

        $this->generator = new SphinxDocumentationGenerator($this->tempOutputPath);

        (new Filesystem())->remove([$this->tempInputPath, $this->tempOutputPath]);
    }

    /** @test */
    function it_does_not_build_non_RST_documentation()
    {
        $anId = $this->createDocumentationId('myDoc');
        $source = $this->createDocumentationSource();
        $documentation = new Documentation($anId, $source, new DateTimeImmutable());

        $builtDocumentation = $this->generator->generate($documentation);

        $this->assertNull($builtDocumentation);
    }

    /** @test */
    function it_builds_RST_documentation_into_the_output_path()
    {
        $anId = $this->createDocumentationId('myDoc');
        $source = $this->createRstDocumentationSourceWithIndex("Docs\n====");
        $documentation = new Documentation($anId, $source, new DateTimeImmutable());

        $built = $this->generator->generate($documentation);

        $this->assertFileExists($this->tempOutputPath . '/myDoc/index.html');
        $this->assertEquals($this->tempOutputPath . '/myDoc/index.html', $built->getIndexPath());
        $this->assertContains('<h1>Docs', file_get_contents($built->getIndexPath()));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    function it_throws_an_exception_if_sphinx_can_not_build_documents()
    {
        $anId = $this->createDocumentationId('myDoc');
        $source = $this->createRstDocumentationSourceWithoutIndex();
        $documentation = new Documentation($anId, $source, new DateTimeImmutable());

        $this->generator->generate($documentation);
    }

    /**
     * @param string $id
     *
     * @return DocumentationId
     */
    private function createDocumentationId($id)
    {
        $anId = $this->getMock(DocumentationId::class);
        $anId->method('__toString')->willReturn($id);

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

<?php

namespace tests\Behat\Borg\Integration\Documentation\SphinxDoc;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Source;
use Behat\Borg\Integration\Documentation\SphinxDoc\Rst;
use Behat\Borg\Integration\Documentation\SphinxDoc\SphinxBuilder;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Filesystem\Filesystem;

class SphinxBuilderTest extends PHPUnit_Framework_TestCase
{
    private $tempInputPath;
    private $tempOutputPath;
    /**
     * @var SphinxBuilder
     */
    private $builder;

    protected function setUp()
    {
        $this->tempInputPath = getenv('TEST_TEMP_PATH') . '/sphinx/input';
        $this->tempOutputPath = getenv('TEST_TEMP_PATH') . '/sphinx/output';
        $this->builder = new SphinxBuilder($this->tempOutputPath, realpath(__DIR__ . '/../../../src/Integration/Symfony/Documentation/Resources/sphinx'), new Filesystem());

        (new Filesystem())->remove([$this->tempInputPath, $this->tempOutputPath]);
    }

    /**
     * @test
     * @expectedException \Behat\Borg\Documentation\Exception\IncompatibleDocumentationGiven
     */
    function it_throws_an_exception_if_non_RST_documentation_provided()
    {
        $anId = $this->createDocumentationId('my/doc', '1.3');
        $source = $this->createDocumentationSource();
        $documentation = new RawDocumentation($anId, new DateTimeImmutable(), $source);

        $this->builder->build($documentation);
    }

    /** @test */
    function it_builds_RST_documentation_into_the_output_path()
    {
        $anId = $this->createDocumentationId('my/doc', 'v1.3');
        $source = $this->createRstDocumentationSourceWithIndex("Docs\n====");
        $documentation = new RawDocumentation($anId, new DateTimeImmutable(), $source);

        $built = $this->builder->build($documentation);

        $this->assertFileExists($this->tempOutputPath . '/my/doc/v1.3/index.html');
        $this->assertEquals(
            $this->tempOutputPath . '/my/doc/v1.3/index.html', $built->indexPath()
        );

        $output = file_get_contents($built->indexPath());

        $this->assertContains('<h1>Docs', $output);
        $this->assertContains('my/doc', $output);
        $this->assertContains('v1.3', $output);
        $this->assertValidTwigSyntax($output);
    }

    /** @test */
    function it_builds_valid_template_when_doc_contains_Twig_like_content()
    {
        $sourceContent = <<<DOC
Trying to hack the twig-bridge theme {{
=======================================

.. code-block:: jinja

    foo {% raw %}

DOC;

        $anId = $this->createDocumentationId('my/doc', 'v1.3');
        $source = $this->createRstDocumentationSourceWithIndex($sourceContent);
        $documentation = new RawDocumentation($anId, new DateTimeImmutable(), $source);

        $built = $this->builder->build($documentation);

        $output = file_get_contents($built->indexPath());

        $this->assertContains('<h1>Trying to hack the twig-bridge theme {{', $output);
        $this->assertValidTwigSyntax($output);
    }

    /**
     * @test
     * @expectedException \Behat\Borg\Documentation\Exception\BuildFailed
     */
    function it_throws_an_exception_if_sphinx_can_not_build_documents()
    {
        $anId = $this->createDocumentationId('my/doc', '1.3');
        $source = $this->createRstDocumentationSourceWithoutIndex();
        $documentation = new RawDocumentation($anId, new DateTimeImmutable(), $source);

        $this->builder->build($documentation);
    }

    /**
     * @param string $projectName
     * @param string $versionString
     *
     * @return DocumentationId
     */
    private function createDocumentationId($projectName, $versionString)
    {
        return new DocumentationId($projectName, $versionString);
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

    private function assertValidTwigSyntax($template)
    {
        $loader = new \Twig_Loader_Array(array('build_output' => $template));
        $twig = new \Twig_Environment($loader);

        $this->addToAssertionCount(1);

        try {
            $nodeTree = $twig->parse($twig->tokenize($template, 'build_output'));
            $twig->compile($nodeTree);
        } catch (\Twig_Error $e) {
            throw new \PHPUnit_Framework_AssertionFailedError('The Twig template is invalid: '.$template, 0, $e);
        }
    }
}

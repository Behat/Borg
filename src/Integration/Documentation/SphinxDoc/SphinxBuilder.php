<?php

namespace Behat\Borg\Integration\Documentation\SphinxDoc;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Exception\BuildFailed;
use Behat\Borg\Documentation\Exception\IncompatibleDocumentationGiven;
use Behat\Borg\Documentation\RawDocumentation;
use DateTimeImmutable;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Builds *.rst documentation using Sphinx-doc.
 *
 * @see http://sphinx-doc.org
 */
final class SphinxBuilder implements Builder
{
    const COMMAND_LINE = 'sphinx-build';

    private $buildPath;
    private $configPath;
    private $filesystem;

    /**
     * @param string $buildPath
     * @param string $configPath
     * @param Filesystem $filesystem
     */
    public function __construct($buildPath, $configPath, Filesystem $filesystem)
    {
        $this->buildPath = $buildPath;
        $this->configPath = $configPath;
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function build(RawDocumentation $documentation)
    {
        $source = $documentation->source();

        if (!$source instanceof Rst) {
            throw new IncompatibleDocumentationGiven(
                sprintf(
                    'Sphinx documentation builder can only build RST-based docs, `%s` given.',
                    get_class($source)
                )
            );
        }

        $sourcePath = $source->path();
        $buildPath = $this->writableBuildPath($documentation);
        $commandLine = $this->commandLine($documentation->documentationId(), $sourcePath, $buildPath);

        $this->executeCommand($commandLine);

        return new BuiltSphinx(
            $documentation->documentationId(), $documentation->documentedAt(), new DateTimeImmutable(), $buildPath
        );
    }

    private function writableBuildPath(RawDocumentation $documentation)
    {
        $buildPath = $this->buildPath . '/' . $documentation->documentationId();
        $this->filesystem->mkdir($buildPath);

        return $buildPath;
    }

    private function commandLine(DocumentationId $anId, $sourcePath, $buildPath)
    {
        return sprintf(
            '%s -b html -c %s -D project="%s" -D version="%s" -D release="%s" %s %s',
            self::COMMAND_LINE,
            $this->configPath,
            $anId->projectName(),
            $anId->versionString(),
            $anId->versionString(),
            $sourcePath,
            $buildPath
        );
    }

    private function executeCommand($commandLine)
    {
        $process = new Process(self::COMMAND_LINE);
        $process->setCommandLine($commandLine);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new BuildFailed(
                sprintf(
                    "Documentation build failed (%s):\n%s",
                    $process->getOutput(),
                    $process->getErrorOutput()
                )
            );
        }
    }
}

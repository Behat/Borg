<?php

namespace Behat\Borg\SphinxDoc\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use Behat\Borg\DocumentationBuilder\DocumentationBuilder;
use Behat\Borg\SphinxDoc\Documentation\RstDocumentationSource;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

final class SphinxDocumentationBuilder implements DocumentationBuilder
{
    const COMMAND_LINE = 'sphinx-build';

    private $buildPath;
    private $filesystem;

    public function __construct($path)
    {
        $this->buildPath = $path;
        $this->filesystem = new Filesystem();
    }

    public function build(Documentation $documentation)
    {
        $source = $documentation->getSource();

        if (!$source instanceof RstDocumentationSource) {
            return null;
        }

        $sourcePath = $source->getPath();
        $buildPath = $this->getWritableBuildPath($documentation);
        $commandLine = $this->getCommandLine($sourcePath, $buildPath);

        $this->executeCommand($commandLine);

        return new BuiltSphinxDocumentation($documentation->getId(), $buildPath);
    }

    private function getWritableBuildPath(Documentation $documentation)
    {
        $buildPath = $this->buildPath . '/' . $documentation->getId();
        $this->filesystem->mkdir($buildPath);

        return $buildPath;
    }

    private function getCommandLine($sourcePath, $buildPath)
    {
        return sprintf(
            '%s -b html -c %s %s %s',
            self::COMMAND_LINE,
            $this->getConfigPath(),
            $sourcePath,
            $buildPath
        );
    }

    private function getConfigPath()
    {
        return realpath(__DIR__ . '/../config');
    }

    private function executeCommand($commandLine)
    {
        $process = new Process(self::COMMAND_LINE);

        $process->setCommandLine($commandLine);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf(
                "%s\n%s",
                $process->getOutput(),
                $process->getErrorOutput()
            ));
        }
    }
}

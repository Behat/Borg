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

    private $path;
    private $process;
    private $filesystem;

    private $baseCommandLine;
    private $configPath;

    public function __construct($path, Process $process = null, Filesystem $filesystem = null)
    {
        $this->path = $path;
        $this->process = $process ?: new Process(self::COMMAND_LINE);
        $this->filesystem = $filesystem ?: new Filesystem();

        $this->baseCommandLine = $this->process->getCommandLine();
        $this->configPath = realpath(__DIR__ . '/../config');
    }

    public function build(Documentation $documentation)
    {
        if (!$documentation->getSource() instanceof RstDocumentationSource) {
            return null;
        }

        $inputPath = $documentation->getSource()->getPath();
        $buildPath = $this->path . '/' . $documentation->getId();

        $this->filesystem->mkdir($buildPath);
        $commandLine = sprintf(
            '%s -b html -c %s %s %s',
            $this->baseCommandLine,
            $this->configPath,
            $inputPath,
            $buildPath
        );

        $this->process->setCommandLine($commandLine);
        $this->process->run();

        if (!$this->process->isSuccessful()) {
            throw new \RuntimeException(sprintf(
                "%s\n%s",
                $this->process->getOutput(),
                $this->process->getErrorOutput()
            ));
        }

        return new BuiltSphinxDocumentation($documentation->getId(), $buildPath);
    }
}

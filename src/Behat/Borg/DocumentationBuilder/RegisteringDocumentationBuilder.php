<?php

namespace Behat\Borg\DocumentationBuilder;

use Behat\Borg\Documentation\Documentation;
use InvalidArgumentException;

/**
 * Builds documentation using another builder and registers the result in the repository.
 */
final class RegisteringDocumentationBuilder implements DocumentationBuilder
{
    private $actualBuilder;
    private $repository;

    /**
     * @param DocumentationBuilder         $actualBuilder
     * @param BuiltDocumentationRepository $repository
     */
    public function __construct(
        DocumentationBuilder $actualBuilder,
        BuiltDocumentationRepository $repository
    ) {
        $this->actualBuilder = $actualBuilder;
        $this->repository = $repository;
    }

    /**
     * Builds documentation using another builder.
     *
     * @param Documentation $documentation
     *
     * @return BuiltDocumentation|null
     *
     * @throws InvalidArgumentException If another builder does not produce result
     */
    public function build(Documentation $documentation)
    {
        $builtDocumentation = $this->actualBuilder->build($documentation);

        if (!$builtDocumentation) {
            throw new InvalidArgumentException('Documentation can not be built.');
        }

        $this->repository->addBuiltDocumentation($builtDocumentation);

        return $builtDocumentation;
    }
}

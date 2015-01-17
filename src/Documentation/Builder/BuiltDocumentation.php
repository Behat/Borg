<?php

namespace Behat\Borg\Documentation\Builder;

use Behat\Borg\Documentation\DocumentationId;
use DateTimeImmutable;

/**
 * Represents built documentation.
 */
interface BuiltDocumentation
{
    /**
     * Returns documentation ID.
     *
     * @return DocumentationId
     */
    public function documentationId();

    /**
     * Returns documentation build path.
     *
     * @return string
     */
    public function buildPath();

    /**
     * Returns the time documentation was built at.
     *
     * @return DateTimeImmutable
     */
    public function builtAt();

    /**
     * Returns the time documentation was created/updated.
     *
     * @return DateTimeImmutable
     */
    public function documentedAt();
}

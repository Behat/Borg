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
     * @return DocumentationId
     */
    public function getId();

    /**
     * Returns documentation build path.
     *
     * @return string
     */
    public function getBuildPath();

    /**
     * Returns path to the built documentation index file.
     *
     * @return string
     */
    public function getIndexPath();

    /**
     * Returns time documentation was built at.
     *
     * @return DateTimeImmutable
     */
    public function getBuildTime();

    /**
     * Returns time documentation was created/updated.
     *
     * @return DateTimeImmutable
     */
    public function getDocumentationTime();
}

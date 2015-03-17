<?php

namespace Behat\Borg\Integration\Extension\Composer;

use Behat\Borg\Extension\Extension;

/**
 * Composer-based extension.
 */
final class ComposerExtension implements Extension
{
    /**
     * @var string
     */
    private $organisationName;
    /**
     * @var string
     */
    private $name;

    /**
     * Initializes extension.
     *
     * @param string $organisationName
     * @param string $name
     */
    public function __construct($organisationName, $name)
    {
        $this->organisationName = $organisationName;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function organisationName()
    {
        return $this->organisationName;
    }

    /**
     * {@inheritdoc}
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->organisationName, $this->name);
    }
}

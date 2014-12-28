<?php

namespace Behat\Borg\Package;

use Behat\Borg\Package\Exception\BadOrganisationNameGiven;
use Behat\Borg\Package\Exception\BadPackageNameGiven;

/**
 * Represents a simple package.
 */
final class SimplePackage implements Package
{
    private $organisation;
    private $name;

    /**
     * Initializes package.
     *
     * @param string $organisation
     * @param string $name
     */
    public function __construct($organisation, $name)
    {
        if (!preg_match('/^[\w\-]+$/', $organisation)) {
            throw new BadOrganisationNameGiven(
                "`$organisation` is not a supported organisation name."
            );
        }

        if (!preg_match('/^[\w\-]+$/', $name)) {
            throw new BadPackageNameGiven("`$name` is not a supported package name.");
        }

        $this->organisation = $organisation;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "{$this->organisation}/{$this->name}";
    }
}

<?php

namespace Behat\Borg\ComposerPackage;

use Behat\Borg\Package\Exception\BadPackageNameGiven;
use Behat\Borg\Package\Package;

/**
 * composer.json-based package.
 */
final class ComposerPackage implements Package
{
    /**
     * @var string
     */
    private $string;

    /**
     * Initializes package.
     *
     * @param string $string
     */
    public function __construct($string)
    {
        if (2 !== count(explode('/', $string))) {
            throw new BadPackageNameGiven(
                "Borg package name should look like `organisation/name`, but {$string} given."
            );
        }

        $this->string = $string;
    }

    /**
     * {@inheritdoc]
     */
    public function getOrganisationName()
    {
        return explode('/', $this->string)[0];
    }

    /**
     * {@inheritdoc]
     */
    public function getName()
    {
        return explode('/', $this->string)[1];
    }

    /**
     * {@inheritdoc]
     */
    public function __toString()
    {
        return $this->string;
    }
}

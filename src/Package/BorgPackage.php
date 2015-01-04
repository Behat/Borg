<?php

namespace Behat\Borg\Package;

use Behat\Borg\Package\Exception\BadPackageNameGiven;

/**
 * borg.json-based package.
 */
final class BorgPackage implements Package
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
    public function getOrganisation()
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

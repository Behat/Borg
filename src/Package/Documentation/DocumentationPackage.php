<?php

namespace Behat\Borg\Package\Documentation;

use Behat\Borg\Package\Exception\BadPackageNameGiven;
use Behat\Borg\Package\Package;

/**
 * borg.json-based package.
 */
final class DocumentationPackage implements Package
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
        if (1 !== preg_match(self::PACKAGE_NAME_REGEX, $string)) {
            throw new BadPackageNameGiven(
                "Composer package name should match `" . self::PACKAGE_NAME_REGEX . "`, but `{$string}` given."
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

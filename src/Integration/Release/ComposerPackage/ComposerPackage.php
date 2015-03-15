<?php

namespace Behat\Borg\Integration\Release\ComposerPackage;

use Behat\Borg\Release\Exception\BadPackageNameGiven;
use Behat\Borg\Release\Package;

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
        if (1 !== preg_match(self::PACKAGE_NAME_REGEX, $string)) {
            throw new BadPackageNameGiven(
                "Composer package name should match `" . self::PACKAGE_NAME_REGEX . "`, but `{$string}` given."
            );
        }

        $this->string = strtolower($string);
    }

    /**
     * {@inheritdoc]
     */
    public function organisationName()
    {
        return explode('/', $this->string)[0];
    }

    /**
     * {@inheritdoc]
     */
    public function name()
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

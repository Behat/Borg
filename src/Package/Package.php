<?php

namespace Behat\Borg\Package;

/**
 * Represents software package.
 */
interface Package
{
    /**
     * @return string
     */
    public function getOrganisation();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function __toString();
}

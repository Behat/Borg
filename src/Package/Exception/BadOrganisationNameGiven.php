<?php

namespace Behat\Borg\Package\Exception;

use InvalidArgumentException;

class BadOrganisationNameGiven extends InvalidArgumentException implements PackageException
{
}

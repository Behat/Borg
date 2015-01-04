<?php

namespace Behat\Borg\Release\Exception;

use InvalidArgumentException;

class BadOrganisationNameGiven extends InvalidArgumentException implements PackageException
{
}

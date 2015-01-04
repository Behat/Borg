<?php

namespace Behat\Borg\Package\Exception;

use InvalidArgumentException;

class BadPackageNameGiven extends InvalidArgumentException implements PackageException
{
}

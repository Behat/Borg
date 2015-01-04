<?php

namespace Behat\Borg\Release\Exception;

use InvalidArgumentException;

class BadPackageNameGiven extends InvalidArgumentException implements PackageException
{
}

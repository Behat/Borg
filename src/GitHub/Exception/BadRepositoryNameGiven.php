<?php

namespace Behat\Borg\GitHub\Exception;

use Behat\Borg\Package\Exception\PackageException;
use InvalidArgumentException;

class BadRepositoryNameGiven extends InvalidArgumentException implements PackageException
{
}

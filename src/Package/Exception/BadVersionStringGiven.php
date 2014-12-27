<?php

namespace Behat\Borg\Package\Exception;

use InvalidArgumentException;

class BadVersionStringGiven extends InvalidArgumentException implements PackageException
{
}

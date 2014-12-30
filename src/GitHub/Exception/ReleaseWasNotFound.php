<?php

namespace Behat\Borg\GitHub\Exception;

use Behat\Borg\Package\Exception\PackageException;
use RuntimeException;

class ReleaseWasNotFound extends RuntimeException implements PackageException
{
}

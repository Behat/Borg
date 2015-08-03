<?php

namespace Behat\Borg\Integration\Release\Composer\Exception;

use Behat\Borg\Release\Exception\ReleaseException;
use InvalidArgumentException;

class AuthorNameIsNotDefined extends InvalidArgumentException implements ReleaseException
{
}

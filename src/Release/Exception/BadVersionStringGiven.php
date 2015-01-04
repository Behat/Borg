<?php

namespace Behat\Borg\Release\Exception;

use InvalidArgumentException;

class BadVersionStringGiven extends InvalidArgumentException implements RepositoryException
{
}

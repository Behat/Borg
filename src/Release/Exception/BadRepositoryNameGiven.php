<?php

namespace Behat\Borg\Release\Exception;

use InvalidArgumentException;

class BadRepositoryNameGiven extends InvalidArgumentException implements RepositoryException
{
}

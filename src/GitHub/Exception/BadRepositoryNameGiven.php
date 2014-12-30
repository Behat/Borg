<?php

namespace Behat\Borg\GitHub\Exception;

use InvalidArgumentException;

class BadRepositoryNameGiven extends InvalidArgumentException implements GitHubException
{
}

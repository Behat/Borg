<?php

namespace Behat\Borg\Integration\Release\GitHub\Exception;

use InvalidArgumentException;

class BadRepositoryNameGiven extends InvalidArgumentException implements GitHubException
{
}

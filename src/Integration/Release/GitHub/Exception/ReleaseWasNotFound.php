<?php

namespace Behat\Borg\Integration\Release\GitHub\Exception;

use RuntimeException;

class ReleaseWasNotFound extends RuntimeException implements GitHubException
{
}

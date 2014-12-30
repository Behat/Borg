<?php

namespace Behat\Borg\GitHub\Exception;

use RuntimeException;

class ReleaseWasNotFound extends RuntimeException implements GitHubException
{
}

<?php

namespace Behat\Borg\Release\Exception;

use InvalidArgumentException;

class FileNotFound extends InvalidArgumentException implements ReleaseException
{
}

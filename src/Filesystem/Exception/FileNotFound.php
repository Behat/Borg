<?php

namespace Behat\Borg\Filesystem\Exception;

use InvalidArgumentException;

class FileNotFound extends InvalidArgumentException implements FilesystemException
{
}

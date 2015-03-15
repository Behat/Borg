<?php

namespace Behat\Borg\Extension\Exception;

use InvalidArgumentException;

class ExtensionNotFound extends InvalidArgumentException implements ExtensionException
{
}

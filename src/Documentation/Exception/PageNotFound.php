<?php

namespace Behat\Borg\Documentation\Exception;

use InvalidArgumentException;

class PageNotFound extends InvalidArgumentException implements DocumentationException
{
}

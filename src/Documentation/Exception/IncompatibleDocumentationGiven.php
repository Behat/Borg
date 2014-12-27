<?php

namespace Behat\Borg\Documentation\Exception;

use InvalidArgumentException;

class IncompatibleDocumentationGiven extends InvalidArgumentException implements DocumentationException
{
}

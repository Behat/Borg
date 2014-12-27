<?php

namespace Behat\Borg\Documentation\Exception;

use InvalidArgumentException;

class RequestedDocumentationWasNotPublished extends InvalidArgumentException implements DocumentationException
{
}

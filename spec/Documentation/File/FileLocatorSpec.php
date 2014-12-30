<?php

namespace spec\Behat\Borg\Documentation\File;

use Behat\Borg\Documentation\DocumentationId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileLocatorSpec extends ObjectBehavior
{
    function let(DocumentationId $anId)
    {
        $this->beConstructedThrough('ofDocumentationFile', [$anId, '/doc/path']);
    }

    function it_holds_documentation_id(DocumentationId $anId)
    {
        $this->getId()->shouldReturn($anId);
    }

    function it_holds_a_relative_file_path()
    {
        $this->getRelativePath()->shouldReturn('/doc/path');
    }
}

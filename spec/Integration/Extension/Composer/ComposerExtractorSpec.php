<?php

namespace spec\Behat\Borg\Integration\Extension\Composer;

use Behat\Borg\Extension\Extractor\Extractor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComposerExtractorSpec extends ObjectBehavior
{
    function it_is_extension_extractor()
    {
        $this->shouldHaveType(Extractor::class);
    }
}

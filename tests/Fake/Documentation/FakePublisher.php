<?php

namespace tests\Behat\Borg\Fake\Documentation;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Publisher\Publisher;

final class FakePublisher implements Publisher
{
    public function publish(BuiltDocumentation $builtDocumentation)
    {
        return PublishedDocumentation::publish($builtDocumentation, __DIR__ . '/build');
    }
}

<?php

namespace spec\Behat\Borg\Fake\Documentation\Builder\Generator;

use Behat\Borg\Documentation\Builder\Generator\DocumentationGenerator;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\DocumentationSource;
use Behat\Borg\Fake\Documentation\Builder\FakeBuiltDocumentation;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FakeDocumentationGeneratorSpec extends ObjectBehavior
{
    function it_is_a_documentation_generator()
    {
        $this->shouldHaveType(DocumentationGenerator::class);
    }

    function it_creates_fake_built_documentation_based_on_documentation_given(
        DocumentationId $anId,
        DocumentationSource $source
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );

        $this->generate($documentation)->shouldHaveType(FakeBuiltDocumentation::class);
    }

    function it_uses_default_time_as_a_build_time(DocumentationId $anId, DocumentationSource $source)
    {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );

        $built = $this->generate($documentation);

        $built->getBuildTime()->shouldHaveType(DateTimeImmutable::class);
    }

    function it_also_allows_to_change_that_build_time(
        DocumentationId $anId,
        DocumentationSource $source,
        DateTimeImmutable $buildTime,
        DateTimeImmutable $newBuildTime
    ) {
        $documentation = new Documentation(
            $anId->getWrappedObject(), $source->getWrappedObject(), new DateTimeImmutable()
        );

        $this->changeBuildTime($newBuildTime);
        $built = $this->generate($documentation);

        $built->getBuildTime()->shouldNotReturn($buildTime);
        $built->getBuildTime()->shouldReturn($newBuildTime);
    }

    function it_exposes_lastly_used_build_time(DateTimeImmutable $buildTime)
    {
        $this->changeBuildTime($buildTime);

        $this->getLastBuildTime()->shouldReturn($buildTime);
    }
}

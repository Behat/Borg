<?php

namespace spec\Behat\Borg\Documentation\Repository;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\ProjectDocumentationId;
use Behat\Borg\Documentation\Publisher\PublishedDocumentation;
use Behat\Borg\Documentation\Repository\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurrentDocumentationRepositorySpec extends ObjectBehavior
{
    function let(Repository $decoratedRepo)
    {
        $this->beConstructedWith($decoratedRepo);
    }

    function it_is_documentation_repository()
    {
        $this->shouldHaveType(Repository::class);
    }

    function it_proxies_save_calls_to_the_decorated_repository(
        Repository $decoratedRepo,
        BuiltDocumentation $built
    ) {
        $documentation = PublishedDocumentation::publish($built->getWrappedObject(), '/');

        $decoratedRepo->save($documentation)->shouldBeCalled();

        $this->save($documentation);
    }

    function it_proxies_findForProject_calls_to_the_decorated_repository(
        Repository $decoratedRepo,
        BuiltDocumentation $built
    ) {
        $documentation = PublishedDocumentation::publish($built->getWrappedObject(), '/');

        $decoratedRepo->findForProject('my/project')->willReturn([$documentation]);

        $this->findForProject('my/project')->shouldReturn([$documentation]);
    }

    function it_proxies_call_to_find_if_provided_documentation_id_is_not_current(
        Repository $decoratedRepo,
        DocumentationId $anId,
        BuiltDocumentation $built
    ) {
        $anId->getVersionString()->willReturn('v2.5');
        $documentation = PublishedDocumentation::publish($built->getWrappedObject(), '/');

        $decoratedRepo->find($anId)->willReturn($documentation);

        $this->find($anId)->shouldReturn($documentation);
    }

    function it_replaces_calls_to_find_current_documentation_with_latest_stable_version_of_project(
        Repository $decoratedRepo,
        BuiltDocumentation $built1,
        BuiltDocumentation $built2,
        BuiltDocumentation $built3
    ) {
        $built1->getDocumentationId()->willReturn(new ProjectDocumentationId('my/project', 'v1.1.1'));
        $built1->getBuildPath()->willReturn();
        $built1->getDocumentationTime()->willReturn();
        $built1->getBuildTime()->willReturn();

        $built2->getDocumentationId()->willReturn(new ProjectDocumentationId('my/project', 'v2.0.0'));
        $built2->getBuildPath()->willReturn();
        $built2->getDocumentationTime()->willReturn();
        $built2->getBuildTime()->willReturn();

        $built3->getDocumentationId()->willReturn(new ProjectDocumentationId('my/project', 'v1.1.2'));
        $built3->getBuildPath()->willReturn();
        $built3->getDocumentationTime()->willReturn();
        $built3->getBuildTime()->willReturn();

        $doc1 = PublishedDocumentation::publish($built1->getWrappedObject(), '/');
        $doc2 = PublishedDocumentation::publish($built2->getWrappedObject(), '/');
        $doc3 = PublishedDocumentation::publish($built3->getWrappedObject(), '/');

        $decoratedRepo->findForProject('my/project')->willReturn([$doc1, $doc2, $doc3]);

        $this->find(new ProjectDocumentationId('my/project', 'current'))->shouldReturn($doc2);
    }
}

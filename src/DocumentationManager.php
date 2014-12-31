<?php

namespace Behat\Borg;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Documentation;
use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Listener\BuildListener;
use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\Page\Page;
use Behat\Borg\Documentation\Publisher\Publisher;

/**
 * Manages documentation by providing high-level accessor methods.
 */
final class DocumentationManager
{
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var Publisher
     */
    private $publisher;
    /**
     * @var BuildListener[]
     */
    private $listeners = [];

    /**
     * Initialize manager.
     *
     * @param Builder   $builder
     * @param Publisher $publisher
     */
    public function __construct(Builder $builder, Publisher $publisher)
    {
        $this->publisher = $publisher;
        $this->builder = $builder;
    }

    /**
     * Registers build listener.
     *
     * @param BuildListener $listener
     */
    public function registerListener(BuildListener $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * Builds provided documentation.
     *
     * @param Documentation $documentation
     */
    public function build(Documentation $documentation)
    {
        $builtDocumentation = $this->builder->build($documentation);

        foreach ($this->listeners as $listener) {
            $listener->documentationWasBuilt($builtDocumentation);
        }
    }

    /**
     * Tries to find the documentation page using its ID.
     *
     * @param DocumentationId $documentationId
     * @param PageId          $pageId
     *
     * @return Page|null
     */
    public function findPage(DocumentationId $documentationId, PageId $pageId)
    {
        if (!$this->publisher->hasPublished($documentationId)) {
            return null;
        }

        $documentation = $this->publisher->getPublished($documentationId);
        if (!$documentation->hasPage($pageId)) {
            return null;
        }

        return $documentation->getPage($pageId);
    }
}

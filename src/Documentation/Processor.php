<?php

namespace Behat\Borg\Documentation;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\Repository\Repository;

/**
 * Processes raw documentation.
 */
final class Processor
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
     * @var Repository
     */
    private $repository;

    /**
     * Initializes processor.
     *
     * @param Builder    $builder
     * @param Publisher  $publisher
     * @param Repository $repository
     */
    public function __construct(Builder $builder, Publisher $publisher, Repository $repository)
    {
        $this->builder = $builder;
        $this->publisher = $publisher;
        $this->repository = $repository;
    }

    /**
     * Processes raw documentation.
     *
     * @param RawDocumentation $documentation
     */
    public function process(RawDocumentation $documentation)
    {
        $built = $this->builder->build($documentation);
        $published = $this->publisher->publish($built);
        $this->repository->add($published);
    }
}

<?php

namespace Behat\Borg\Documentation\Processor;

use Behat\Borg\Documentation\Builder\Builder;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Documentation\RawDocumentation;
use Behat\Borg\Documentation\Repository\Repository;

/**
 * Processes documentation by building, publishing and saving it.
 */
final class BuildingProcessor implements Processor
{
    /**
     * Initialize manager.
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
     * {@inheritdoc}
     */
    public function process(RawDocumentation $documentation)
    {
        $built = $this->builder->build($documentation);
        $published = $this->publisher->publish($built);
        $this->repository->save($published);
    }
}

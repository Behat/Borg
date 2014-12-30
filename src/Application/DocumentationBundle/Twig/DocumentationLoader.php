<?php

namespace Behat\Borg\Application\DocumentationBundle\Twig;

use Behat\Borg\Documentation\Publisher\Publisher;
use Twig_ExistsLoaderInterface;
use Twig_LoaderInterface;

final class DocumentationLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{
    private static $regex = '#^documentation:(?<path>.*)$#';
    private $publisher;
    private $cache = [];

    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function exists($template)
    {
        if (!preg_match(self::$regex, $template, $m)) {
            return false;
        }

        return file_exists($m['path']);
    }

    /**
     * {@inheritdoc}
     */
    public function getSource($template)
    {
        return file_get_contents($this->findTemplate($template));
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($template)
    {
        return $this->findTemplate($template);
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        return filemtime($this->findTemplate($name)) <= $time;
    }

    private function findTemplate($template)
    {
        $logicalName = (string)$template;

        if (isset($this->cache[$logicalName])) {
            return $this->cache[$logicalName];
        }

        preg_match(self::$regex, $template, $m);

        return $this->cache[$logicalName] = $m['path'];
    }
}

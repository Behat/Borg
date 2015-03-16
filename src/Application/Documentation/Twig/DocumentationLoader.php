<?php

namespace Behat\Borg\Application\Documentation\Twig;

use Twig_Error_Loader;
use Twig_ExistsLoaderInterface;
use Twig_LoaderInterface;

final class DocumentationLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{
    private static $regex = '#^documentation:(?<path>.*+)$#';
    private $cache = [];

    public function exists($template)
    {
        $logicalName = (string) $template;

        if (isset($this->cache[$logicalName])) {
            return true;
        }

        if (!preg_match(self::$regex, $template, $m)) {
            return false;
        }

        if (file_exists($m['path'])) {
            $this->cache[$logicalName] = $m['path'];

            return true;
        }

        return false;
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
        $logicalName = (string) $template;

        if (isset($this->cache[$logicalName])) {
            return $this->cache[$logicalName];
        }

        if (!preg_match(self::$regex, $template, $m)) {
            throw new Twig_Error_Loader(sprintf('Unsupported template name "%s" (expecting "documentation:path").', $logicalName));
        }

        if (!file_exists($m['path'])) {
            throw new Twig_Error_Loader(sprintf('Unable to find template "%s"', $logicalName));
        }

        return $this->cache[$logicalName] = $m['path'];
    }
}

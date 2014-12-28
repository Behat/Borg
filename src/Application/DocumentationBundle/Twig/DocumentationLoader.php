<?php

namespace Behat\Borg\Application\DocumentationBundle\Twig;

use Behat\Borg\Documentation\DocumentationId;
use Behat\Borg\Documentation\Publisher\Publisher;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\SimplePackage;
use Behat\Borg\Package\Version;
use Twig_Loader_Filesystem;

final class DocumentationLoader extends Twig_Loader_Filesystem
{
    private static $regex = '#^docs::(?<org>[\w\-]+):(?<pkg>[\w\-]+):v(?<ver>\d+\.\d+)/(?<path>.*)$#';
    private $publisher;

    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;

        parent::__construct(array());
    }

    public function exists($template)
    {
        if (!preg_match(self::$regex, $template, $m)) {
            return false;
        }

        $id = $this->getDocumentationId($m['org'], $m['pkg'], $m['ver']);

        if (!$this->publisher->hasPublished($id)) {
            return false;
        }

        return file_exists($this->getFullPath($id, $m['path']));
    }

    protected function findTemplate($template)
    {
        $logicalName = (string)$template;

        if (isset($this->cache[$logicalName])) {
            return $this->cache[$logicalName];
        }

        preg_match(self::$regex, $template, $m);

        $id = $this->getDocumentationId($m['org'], $m['pkg'], $m['ver']);
        $file = $this->getFullPath($id, $m['path']);

        return $this->cache[$logicalName] = $file;
    }

    private function getDocumentationId($organisation, $package, $version)
    {
        return new ReleaseDocumentationId(
            new Release(new SimplePackage($organisation, $package), Version::string($version))
        );
    }

    private function getFullPath(DocumentationId $id, $path)
    {
        return $this->publisher->getPublished($id)->getPublishPath() . '/' . $path;
    }
}

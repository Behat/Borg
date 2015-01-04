<?php

use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Release\Version;
use Fake\Release\FakeRepository;

trait DocumentationTransformations
{
    /**
     * @Transform :repository
     */
    public function transformStringToRepository($string)
    {
        return FakeRepository::named($string);
    }

    /**
     * @Transform :package
     */
    public function transformStringToPackage($string)
    {
        return FakeRepository::named($string);
    }

    /**
     * @Transform :version
     */
    public function transformStringToVersion($string)
    {
        return Version::string($string);
    }

    /**
     * @Transform :pageId
     */
    public function transformStringToPageId($string)
    {
        return new PageId($string);
    }

    /**
     * @Transform :time
     */
    public function transformStringToDate($string)
    {
        return DateTimeImmutable::createFromFormat('d.m.Y, H:i:s', $string, new DateTimeZone('Z'));
    }
}

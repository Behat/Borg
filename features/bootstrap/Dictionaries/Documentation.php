<?php

namespace Dictionaries;

use Behat\Borg\Documentation\Page\PageId;
use DateTimeImmutable;
use DateTimeZone;

trait Documentation
{
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

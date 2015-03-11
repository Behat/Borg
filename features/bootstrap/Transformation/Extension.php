<?php

namespace Transformation;

use Fake\Extension\FakeExtension;

trait Extension
{
    /**
     * @Transform :extension
     */
    public function transformStringToExtension($string)
    {
        return FakeExtension::named($string);
    }

    /**
     * @Transform :count
     */
    public function transformStringToCount($string)
    {
        return (int)$string;
    }
}

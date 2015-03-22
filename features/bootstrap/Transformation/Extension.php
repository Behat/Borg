<?php

namespace Transformation;

use Fake\Extension\FakeExtensionPackage;

trait Extension
{
    /**
     * @Transform :extensionPackage
     */
    public function transformStringToExtensionPackage($string)
    {
        return FakeExtensionPackage::named($string);
    }

    /**
     * @Transform :count
     */
    public function transformStringToCount($string)
    {
        return (int)$string;
    }
}

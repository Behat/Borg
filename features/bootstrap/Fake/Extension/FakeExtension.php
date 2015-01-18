<?php

namespace Fake\Extension;

use Behat\Borg\Extension\Extension;

final class FakeExtension implements Extension
{
    private $name;

    public static function named($name)
    {
        $extension = new FakeExtension();
        $extension->name = $name;

        return $extension;
    }

    public function name()
    {
        return $this->name;
    }

    private function __construct() { }
}

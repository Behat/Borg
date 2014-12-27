<?php

namespace Behat\Borg;

use Behat\Borg\Package\Listener\ReleaseListener;
use Behat\Borg\Package\Release;

final class ReleaseManager
{
    private $listeners = [];

    public function registerListener(ReleaseListener $listener)
    {
        $this->listeners[] = $listener;
    }

    public function release(Release $release)
    {
        foreach ($this->listeners as $listener) {
            $listener->packageWasReleased($release);
        }
    }
}

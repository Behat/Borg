<?php

namespace Behat\Borg\Documentation\Listener;

use Behat\Borg\Documentation\Builder\BuiltDocumentation;

/**
 * Provides a way to listen to documentation build events.
 */
interface BuildListener
{
    /**
     * Notifies listener when documentation was successfully built.
     *
     * @param BuiltDocumentation $builtDocumentation
     */
    public function documentationWasBuilt(BuiltDocumentation $builtDocumentation);
}

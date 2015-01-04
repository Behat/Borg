<?php

/*
 * This file is part of the borg.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fake\Package;

use Behat\Borg\Package\Finder\PackageFinder;
use Behat\Borg\Release\Downloader\Download;

final class FakePackageFinder implements PackageFinder
{
    /**
     * {@inheritdoc}
     */
    public function findPackage(Download $download)
    {
        // TODO: Implement findPackage() method.
    }
}

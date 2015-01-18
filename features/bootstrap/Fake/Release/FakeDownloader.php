<?php

namespace Fake\Release;

use Behat\Borg\Release\Downloader\Downloader;
use Behat\Borg\Release\Release;

final class FakeDownloader implements Downloader
{
    public function download(Release $release)
    {
        $repository = $release->repository();

        if (!$repository instanceof FakeRepository) {
            throw new \InvalidArgumentException('FakeDownloader works only with FakeRepository.');
        }

        return $repository->download($release);
    }
}

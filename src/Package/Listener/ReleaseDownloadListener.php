<?php

namespace Behat\Borg\Package\Listener;

use Behat\Borg\Package\Downloader\DownloadedRelease;

interface ReleaseDownloadListener
{
    public function releaseWasDownloaded(DownloadedRelease $downloadedRelease);
}

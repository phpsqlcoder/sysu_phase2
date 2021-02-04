<?php

namespace UniSharp\LaravelFilemanager\Controllers;

/**
 * Class DownloadController.
 */
class DownloadController extends LfmController
{
    /**
     * Download a file.
     *
     * @return mixed
     */
    public function getDownload()
    {
        ob_end_clean();

        return response()->download(parent::getCurrentPath(request('file')));
    }
}

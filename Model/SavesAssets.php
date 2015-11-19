<?php

namespace Depotwarehouse\SoDoge\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use File;

class SavesAssets
{
    /**
     * Given a particular UploadedFile, hash the name, and move it to disk.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return string
     */
    public function save(UploadedFile $file)
    {
        $hash = hash_file('sha256', $file->getRealPath());

        $filename = $hash . "." . $file->getClientOriginalExtension();

        if (!File::exists(config('app.base_upload_dir') . $filename)) {
            $file->move(config('app.base_upload_dir'), $filename);
        }

        return $filename;
    }
}

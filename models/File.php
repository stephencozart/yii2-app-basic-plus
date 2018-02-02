<?php

namespace app\models;


use app\traits\SoftDeletes;
use app\traits\Timestamps;

class File extends base\File
{
    use Timestamps, SoftDeletes;

    public function getStoragePath()
    {
        $folder = str_pad($this->id, 2, 0, STR_PAD_LEFT);

        return sprintf('%s/%s', $folder, $this->file_name);
    }
}
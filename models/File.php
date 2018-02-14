<?php

namespace app\models;


use app\traits\SoftDeletes;
use app\traits\Timestamps;

class File extends base\File
{
    use Timestamps, SoftDeletes;

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'url';

        return $fields;
    }

    public static function resolveFolder($id)
    {
        return str_pad($id, 2, 0, STR_PAD_LEFT);
    }

    public function getStoragePath()
    {
        return sprintf('%s/%s', self::resolveFolder($this->id), $this->file_name);
    }

    public function getUrl()
    {
        if ($this->id === null || empty($this->file_name)) {

            return null;

        }

        return sprintf('/storage/%s/%s/%s', $this->id, self::resolveFolder($this->id), $this->file_name);
    }
}
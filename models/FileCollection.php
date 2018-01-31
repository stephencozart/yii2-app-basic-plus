<?php

namespace app\models;


use app\traits\SoftDeletes;
use app\traits\Timestamps;

class FileCollection extends base\FileCollection
{
    use SoftDeletes, Timestamps;

    public static $deletedAtAttribute = 'deleted_at';
}

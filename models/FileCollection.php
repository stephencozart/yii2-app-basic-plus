<?php

namespace app\models;


use app\traits\SoftDeletes;

class FileCollection extends base\FileCollection
{
    use SoftDeletes;

    public static $deletedAtAttribute = 'deleted_at';
}

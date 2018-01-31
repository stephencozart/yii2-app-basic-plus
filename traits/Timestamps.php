<?php

namespace app\traits;


trait Timestamps
{
    public function beforeSave($insert)
    {
        $createdAtAttribute = isset(self::$createdAtAttribute) ? self::$createdAtAttribute : 'created_at';

        $updatedAtAttribute = isset(self::$updatedAtAttribute) ? self::$updatedAtAttribute : 'updated_at';

        $this->setAttribute($updatedAtAttribute, date('Y-m-d H:i:s'));

        if ($insert) {

            $this->setAttribute($createdAtAttribute, date('Y-m-d H:i:s'));

        }

        return parent::beforeSave($insert);
    }
}
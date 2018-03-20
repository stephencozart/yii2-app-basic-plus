<?php

namespace app\models;


use app\traits\SoftDeletes;
use app\traits\Timestamps;

/**
 * Class EntryType
 * @package app\models
 * @property Field[] $fieldRegistry
 */
class EntryType extends base\EntryType
{
    use Timestamps,SoftDeletes;

    public function getFieldRegistry()
    {
        return $this->hasMany(Field::class, ['entry_type_handle'=>'handle'])->andWhere(['parent' => '']);
    }

    public function fields()
    {
        $fields = parent::fields();

        $fields['fieldRegistry'] = function() {
            return $this->getFieldRegistry()->orderBy('position, id')->all();
        };
        
        return $fields;
    }
}

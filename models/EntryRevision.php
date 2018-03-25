<?php

namespace app\models;


use app\fields\DecoratorFactory;

/**
 * Class EntryRevision
 * @package app\models
 * @property EntryRevision $published
 */
class EntryRevision extends Entry
{
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'data';

        unset($fields['revisions']);

        return $fields;
    }

    public function extraFields()
    {
        $fields = parent::extraFields();

        $fields[] = 'published';

        return $fields;
    }

    public function afterFind()
    {
        $parent = parent::afterFind();

        return $parent;
    }

    public function getPublished()
    {
        return $this->hasOne(EntryRevision::class, ['entry_uid'=>'entry_uid'])->andWhere(['status'=>self::STATUS_PUBLISHED]);
    }
}
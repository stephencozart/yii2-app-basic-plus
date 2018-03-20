<?php

namespace app\models;


use app\fields\DecoratorFactory;

class EntryRevision extends Entry
{
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'data';

        unset($fields['revisions']);

        return $fields;
    }

    public function afterFind()
    {
        $parent = parent::afterFind();

        return $parent;
    }

}
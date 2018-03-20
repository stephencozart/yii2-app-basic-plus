<?php

namespace app\models;


use app\traits\SoftDeletes;
use app\traits\Timestamps;

class Field extends base\Field
{
    use Timestamps, SoftDeletes;

    public function fields() 
    {
        $fields = parent::fields();

        $fields['children'] = function() {
            return Field::find()->where(['parent' => $this->handle])->orderBy('position, id')->all();
        };

        return $fields;
    }
}
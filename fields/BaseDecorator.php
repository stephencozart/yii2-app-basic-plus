<?php

namespace app\fields;


use yii\base\BaseObject;

abstract class BaseDecorator extends BaseObject
{
    abstract public function decorate($value);

}

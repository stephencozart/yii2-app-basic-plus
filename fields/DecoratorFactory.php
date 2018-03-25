<?php

namespace app\fields;


use app\models\EntryType;
use yii\base\BaseObject;

class DecoratorFactory extends BaseObject
{
    protected static $registry = [
        'asset-input' => AssetInputDecorator::class,
        'location-input' => LocationInputDecorator::class
    ];

    /**
     * @param $fieldTypeHandle
     * @return BaseDecorator
     */
    public static function createDecorator($fieldTypeHandle)
    {
        if (isset(self::$registry[$fieldTypeHandle])) {

            $decoratorClass = self::$registry[$fieldTypeHandle];

        } else {

            $decoratorClass = PassThroughDecorator::class;

        }

        return new $decoratorClass();
    }
}
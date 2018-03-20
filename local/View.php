<?php

namespace app\local;


use app\fields\DecoratorFactory;
use app\models\Entry;
use app\models\EntryType;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class View extends \yii\web\View
{
    /** @var EntryType */
    protected $entryType;

    protected $decoratorMap = [];

    public function setEntryType(EntryType $entryType)
    {
        $this->entryType = $entryType;
    }

    public function field($name, Entry $entry)
    {
        if ($this->entryType === null) {

            throw new InvalidConfigException('Entry type not set');

        }

        // just return the value from entry if calling something like Entry::$title
        if ($entry->hasAttribute($name)) {

            return $entry->getAttribute($name);

        }

        $fieldTypeMap = ArrayHelper::map($this->entryType->fieldRegistry, 'handle','field_type_handle');

        if (isset($fieldTypeMap[$name]) === false) {

            throw new InvalidArgumentException($name . ' is not part of the field registry for ' . $this->entryType->name);

        }

        $fieldType = $fieldTypeMap[$name];

        $value = null;

        if (isset($entry->data[$name])) {

            $value = $entry->data[$name];

        }

        $decorator = $this->getDecorator($fieldType);


        $value = $decorator->decorate($value);

        return $value;

    }

    public function getDecorator($fieldType)
    {
        if (!isset($this->decoratorMap[$fieldType])) {

            $this->decoratorMap[$fieldType] = DecoratorFactory::createDecorator($fieldType);

        }

        return $this->decoratorMap[$fieldType];
    }
}
<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "field".
 *
 * @property int $id
 * @property string $entry_type_handle
 * @property string $field_type_handle
 * @property string $handle
 * @property string $parent
 * @property string $label
 * @property int $required
 * @property string $instructions
 * @property string $placeholder
 * @property string $default_value
 * @property string $choices
 * @property int $min
 * @property int $max
 * @property string $step
 * @property string $pattern
 * @property int $searchable
 * @property int $repeat_max
 * @property string $prepend
 * @property string $append
 * @property int $position
 * @property string $layout
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Field extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_type_handle', 'field_type_handle', 'handle'], 'required'],
            [['choices'], 'string'],
            [['min', 'max', 'repeat_max', 'position'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['entry_type_handle'], 'string', 'max' => 150],
            [['field_type_handle', 'handle', 'parent', 'label', 'placeholder'], 'string', 'max' => 100],
            [['required', 'searchable'], 'boolean'],
            [['instructions', 'default_value', 'step', 'pattern', 'prepend', 'append', 'layout'], 'string', 'max' => 255],
            [['deleted_at', 'entry_type_handle', 'handle'], 'unique', 'targetAttribute' => ['deleted_at', 'entry_type_handle', 'handle']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entry_type_handle' => 'Entry Type Handle',
            'field_type_handle' => 'Field Type Handle',
            'handle' => 'Handle',
            'parent' => 'Parent',
            'label' => 'Label',
            'required' => 'Required',
            'instructions' => 'Instructions',
            'placeholder' => 'Placeholder',
            'default_value' => 'Default Value',
            'choices' => 'Choices',
            'min' => 'Min',
            'max' => 'Max',
            'step' => 'Step',
            'pattern' => 'Pattern',
            'searchable' => 'Searchable',
            'repeat_max' => 'Repeat Max',
            'prepend' => 'Prepend',
            'append' => 'Append',
            'position' => 'Position',
            'layout' => 'Layout',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}

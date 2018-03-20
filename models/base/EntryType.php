<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "entry_type".
 *
 * @property int $id
 * @property string $handle
 * @property int $enabled
 * @property string $default_sort
 * @property string $name
 * @property string $content
 * @property int $items_per_page
 * @property string $meta_title
 * @property string $meta_description
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class EntryType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%entry_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['items_per_page'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['handle', 'name'], 'string', 'max' => 150],
            [['enabled'], 'boolean'],
            [['default_sort'], 'string', 'max' => 255],
            [['meta_title'], 'string', 'max' => 70],
            [['meta_description'], 'string', 'max' => 165],
            [['deleted_at', 'handle'], 'unique', 'targetAttribute' => ['deleted_at', 'handle']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'handle' => 'Handle',
            'enabled' => 'Enabled',
            'default_sort' => 'Default Sort',
            'name' => 'Name',
            'content' => 'Content',
            'items_per_page' => 'Items Per Page',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}

<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $owner_type
 * @property string $owner_id
 * @property string $category
 * @property string $name
 * @property string $file_name
 * @property string $mime_type
 * @property integer $file_size
 * @property integer $sort_order
 * @property integer $width
 * @property integer $height
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'file_name'], 'required'],
            [['file_size', 'sort_order', 'width', 'height'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['owner_type', 'owner_id', 'category', 'mime_type'], 'string', 'max' => 100],
            [['name', 'file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_type' => 'Owner Type',
            'owner_id' => 'Owner ID',
            'category' => 'Category',
            'name' => 'Name',
            'file_name' => 'File Name',
            'mime_type' => 'Mime Type',
            'file_size' => 'File Size',
            'sort_order' => 'Sort Order',
            'width' => 'Width',
            'height' => 'Height',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}

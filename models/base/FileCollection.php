<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "file_collection".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class FileCollection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_collection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['slug', 'name'], 'string', 'max' => 100],
            [['slug', 'deleted_at'], 'unique', 'targetAttribute' => ['slug', 'deleted_at'], 'message' => 'The combination of Slug and Deleted At has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}

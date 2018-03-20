<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%entry}}".
 *
 * @property int $id
 * @property int $is_master
 * @property string $entry_uid
 * @property int $entry_type_id
 * @property string $entry_type_handle
 * @property string $status
 * @property string $title
 * @property string $handle
 * @property string $content
 * @property string $meta_title
 * @property string $meta_description
 * @property string $publish_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Entry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%entry}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_type_handle', 'status', 'title', 'handle'], 'required'],
            [['entry_uid'], 'string', 'max' => 64],
            [['entry_type_id'], 'integer'],
            [['is_master'], 'integer'],
            [['content'], 'string'],
            [['publish_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['entry_type_handle', 'title', 'handle', 'meta_title', 'meta_description'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
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
            'status' => 'Status',
            'title' => 'Title',
            'handle' => 'Handle',
            'content' => 'Content',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'publish_at' => 'Publish At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}

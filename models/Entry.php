<?php
namespace app\models;

use app\models\base\Entry as BaseEntry;
use app\traits\SoftDeletes;
use app\traits\Timestamps;
use Ramsey\Uuid\Uuid;
use yii\db\Query;

/**
 * Class Entry
 * @package app\models
 * @property EntryType $entryType;
 */
class Entry extends BaseEntry {

    use Timestamps,SoftDeletes;

    const STATUS_DRAFT = 'draft';

    const STATUS_PUBLISHED = 'published';

    public $data = [];

    public function rules()
    {
        $rules = parent::rules();

        $rules[] = [['data'], 'safe'];

        return $rules;
    }

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'data';

        $fields['revisions'] = function() {

            return EntryRevision::find()->andWhere(['entry_uid' => $this->entry_uid])->orderBy('updated_at DESC')->all();

        };

        return $fields;
    }

    public function afterFind()
    {
        $query = new Query();
        $reader = $query->from('{{%entry_data}}')->where(['entry_id' => $this->id])->createCommand()->query();
        foreach($reader as $row) {
            $this->data[$row['key']] = $row['value'];
        }
        return parent::afterFind();
    }

    public function afterSave($insert, $changedAttributes)
    {
        // only save entry type data on database inserts.
        if ($insert) {
            $columns = [
                'entry_id',
                'key',
                'value'
            ];
            $rows = [];
            foreach($this->data as $key => $value) {
                $rows[] = [
                    $this->id,
                    $key,
                    $value
                ];
            }

            \Yii::$app->db->createCommand()->batchInsert('{{%entry_data}}', $columns, $rows)->execute();
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function getEntryType()
    {
        return $this->hasOne(EntryType::class, ['entry_type_id' => 'id']);
    }
}
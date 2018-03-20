<?php

namespace app\modules\admin\controllers;


use app\models\EntryType;
use app\models\base\EntryType as BaseEntryType;
use app\models\Field;
use app\modules\admin\ApiController;
use yii\base\Event;

class EntryTypeController extends ApiController
{
    public $modelClass = EntryType::class;

    public function init()
    {
        Event::on(BaseEntryType::class, BaseEntryType::EVENT_BEFORE_DELETE, function(Event $event) {

            /** @var BaseEntryType  $model */
            $model = $event->sender;

            if ($relation = $model->getRelation('fieldRegistry', false)) {

                foreach($relation->all() as $relatedItem) {

                    $relatedItem->delete();

                }

            }

        });

        parent::init();
    }

    public function actionSortFields($id)
    {
        $body = \Yii::$app->request->getRawBody();

        $fields = json_decode($body, true);

        foreach($fields as $p => $field) {
            $attributes = [
                'position' => $p+1,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Field::updateAll($attributes, ['id' => $field['id']]);
        }
        return $body;
    }
}
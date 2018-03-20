<?php

namespace app\modules\admin\controllers;

use app\modules\admin\ApiController;
use app\models\Entry;
use Ramsey\Uuid\Uuid;
use yii\base\Event;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\Query;
use yii\web\MethodNotAllowedHttpException;

class EntryController extends ApiController {
    
    public $modelClass = Entry::class;

    public function init()
    {
        parent::init();

        Event::on(Entry::class, Entry::EVENT_BEFORE_VALIDATE, function(Event $event) {
            $uuid = Uuid::uuid4();
            if (empty($event->sender->entry_uid)) {
                $event->sender->entry_uid = $uuid->toString();
            }
        });

        Event::on(Entry::class, Entry::EVENT_BEFORE_INSERT, function(Event $event) {
            $event->sender->is_master = 1;
        });

        Event::on(Entry::class,  Entry::EVENT_AFTER_INSERT, function(Event $event) {
            $condition = ['and', ['!=', 'id', $event->sender->id], ['entry_uid' => $event->sender->entry_uid]];
            $attributes = ['is_master' => 0];
            if ($event->sender->status === Entry::STATUS_PUBLISHED) {
                $attributes['status'] = Entry::STATUS_DRAFT;
            }
            Entry::updateAll($attributes, $condition);
        });
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * @param $id
     * @throws Exception
     * @throws MethodNotAllowedHttpException
     */
    public function actionPublish($id)
    {
        if (\Yii::$app->request->isPost) {

            /** @var Entry $entry */
            $entry = Entry::findOne($id);

            $entry->status = Entry::STATUS_PUBLISHED;

            $entry->is_master = 1;

            $entry->save();

            $condition = ['and', ['entry_uid' => $entry->entry_uid], ['!=', 'id', $entry->id]];

            $count = Entry::updateAll(['status' => Entry::STATUS_DRAFT, 'is_master' => 0], $condition);

            if ($count === 0) {

                throw new Exception('Entry status update failed');

            }

            $entry->refresh();

            return $entry;

        } else {

            throw new MethodNotAllowedHttpException();

        }
    }

    /**
     * @param $id
     * @throws Exception
     * @throws MethodNotAllowedHttpException
     */
    public function actionUnPublish($id)
    {
        if (\Yii::$app->request->isPost) {

            $count = Entry::updateAll(['status' => Entry::STATUS_DRAFT], ['id' => $id]);

            if ($count === 0) {

                throw new Exception('Entry status update failed');

            }

        } else {

            throw new MethodNotAllowedHttpException();

        }
    }

    public function prepareDataProvider()
    {
        $query = Entry::find();
        $query->andWhere(['is_master' => 1]);

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}
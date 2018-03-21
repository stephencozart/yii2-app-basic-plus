<?php

namespace app\controllers;


use app\models\EntryRevision;
use app\models\EntryType;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EntryTypeController extends Controller
{
    public function init()
    {
        $this->viewPath = '@app/views/entry';
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionView($handle)
    {

        if (\Yii::$container->has(EntryType::class)) {

            /** @var EntryType $entryType */
            $entryType = \Yii::$container->get(EntryType::class);

            $this->view->setEntryType($entryType);

        } else {

            throw new NotFoundHttpException();

        }

        $query = EntryRevision::find()->andWhere(['entry_type_handle' => $entryType->handle, 'status' => EntryRevision::STATUS_PUBLISHED]);

        $isDescending = substr($entryType->default_sort, 0, 1) === '-';

        $defaultOrderAttribute = $isDescending ? substr($entryType->default_sort, 1) : $entryType->default_sort;

        $defaultSortDirection = $isDescending ? SORT_DESC : SORT_ASC;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $entryType->items_per_page,
            ],
            'sort' => [
                'defaultOrder' => [
                    $defaultOrderAttribute => $defaultSortDirection
                ]
            ],
        ]);

        return $this->render($handle, [
            'entryType' => $entryType,
            'dataProvider' => $dataProvider
        ]);

    }
}
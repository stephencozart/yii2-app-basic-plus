<?php

namespace app\modules\admin\controllers;


use app\models\FileCollection;
use app\modules\admin\ApiController;
use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;

class FileManagerController extends ApiController
{
    public $modelClass = FileCollection::class;

    public function actionCollections()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FileCollection::find()
        ]);

        return $dataProvider;
    }

}
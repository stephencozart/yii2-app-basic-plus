<?php

namespace app\controllers;


use app\models\Entry;
use app\models\EntryType;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EntryController extends Controller
{
    public function actionView($entryTypeHandle, $entryHandle)
    {
        $entry = Entry::find()
            ->where([
                'entry_type_handle' => $entryTypeHandle,
                'handle' => $entryHandle,
                'status' => Entry::STATUS_PUBLISHED
            ])->one();

        if ($entry === null) {

            throw new NotFoundHttpException();

        }

        $entryType = \Yii::$container->get(EntryType::class);

        $this->view->setEntryType($entryType);

        return $this->render($entryType->handle.'-single', [
            'entryType' => $entryType,
            'entry' => $entry
        ]);
    }
}
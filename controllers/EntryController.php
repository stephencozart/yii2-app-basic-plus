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
        $revision = \Yii::$app->request->get('revision');

        $perms = [
            'view-entries',
            'update-entries',
            'create-entries',
            'delete-entries'
        ];

        $canPreview = false;

        foreach($perms as $perm) {
            if (\Yii::$app->user->can($perm)) {
                $canPreview = true;
                break;
            }
        }

        $condition = [
            'entry_type_handle' => $entryTypeHandle,
            'handle' => $entryHandle,
            'status' => Entry::STATUS_PUBLISHED
        ];

        if ($revision && $canPreview) {
            $condition['status'] = [Entry::STATUS_PUBLISHED, Entry::STATUS_DRAFT];
            $condition['id'] = $revision;
        }

        $entry = Entry::find()
            ->where($condition)->one();

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
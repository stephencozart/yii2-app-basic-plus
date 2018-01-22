<?php
/**
 * Created by PhpStorm.
 * User: stephencozart
 * Date: 1/21/18
 * Time: 9:18 PM
 */

namespace app\modules\admin;


use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Response;

abstract class ApiController extends ActiveController
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles'=>['admin']
                    ]
                ],
            ],
        ];
    }

    public function init()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }
}
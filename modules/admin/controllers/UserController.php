<?php

namespace app\modules\admin\controllers;


use app\models\User;
use app\modules\admin\ApiController;

class UserController extends ApiController
{
    public $modelClass = User::class;

    public function actionSendActivation()
    {
        $request = json_decode(\Yii::$app->request->getRawBody(), true);

        /** @var User $user */
        $user = User::findByEmail($request['email']);

        if ($user === null) {

            \Yii::$app->response->statusCode = 422;

            \Yii::$app->response->statusText = 'No accounts exist for the email ' . $request['email'];

        } else {

            $user->activation_code = \Yii::$app->security->generateRandomString();

            $user->save();

            \Yii::$app->mailer->compose('user/activate', ['user' => $user])
                ->setFrom(\Yii::$app->params['reply_to'])
                ->setTo($user->email)
                ->setSubject('Account Activation Instructions')
                ->send();

        }


    }
}
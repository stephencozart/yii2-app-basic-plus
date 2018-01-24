<?php namespace app\controllers;

use app\models\forms\PasswordResetForm;
use app\models\forms\UserForm;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller {

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_LOGIN;

        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_REGISTER;

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {

            \Yii::$app->session->addFlash('success', 'Your account has been created.');

            return $this->redirect(['user/login']);
        }

        return $this->render('register', ['model' => $model]);
    }


    /**
     * @return string
     */
    public function actionRequestReset()
    {
        $model = new PasswordResetForm();
        $model->scenario = PasswordResetForm::SCENARIO_REQUEST;

        if ($model->load(\Yii::$app->request->post()) && $model->request()) {

            // send the user an email with the reset token
            \Yii::$app->mailer->compose('user/reset', ['user' => $model->getUser()])
                ->setFrom(\Yii::$app->params['reply_to'])
                ->setTo($model->getUser()->email)
                ->setSubject('Reset Password')
                ->send();

            \Yii::$app->session->addFlash('success', 'An email has been sent to your account with a reset token.');
        }

        return $this->render('request-reset', ['model' => $model]);
    }

    /**
     * @param $id
     * @param $key
     * @return string
     */
    public function actionReset($id, $key)
    {
        $user = User::find()->where(['id' => $id])->andWhere(['reset_code' => $key])->one();

        if ($user === null) {
            \Yii::$app->session->addFlash('error', 'The reset key for this account is invalid.');
            return $this->redirect(['user/reset']);
        }

        $model = new PasswordResetForm();
        $model->scenario = PasswordResetForm::SCENARIO_RESET;
        $model->setUser($user);

        if ($model->load(\Yii::$app->request->post()) && $model->reset()) {
            \Yii::$app->session->addFlash('success', 'The password has been reset.');
            return $this->redirect(['user/login']);
        }

        return $this->render('reset', ['model' => $model]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: stephencozart
 * Date: 4/12/16
 * Time: 10:50 PM
 */

namespace app\modules\admin\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use Yii;

class DashboardController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['login', 'logout', 'index'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['login'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => ['logout'],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['index'],
						'roles'=>['admin']
					]
				],
			],
		];
	}

	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}
		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->redirect(['login']);
	}

	public function actionIndex()
	{
		return $this->render('index');
	}
}
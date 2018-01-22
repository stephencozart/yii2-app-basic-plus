<?php
/**
 * Created by PhpStorm.
 * User: stephencozart
 * Date: 4/12/16
 * Time: 10:50 PM
 */

namespace app\modules\admin\controllers;


use app\models\forms\UserForm;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class AppController extends Controller
{


	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['login', 'logout', 'index', 'error'],
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
                        'actions' => ['error','test'],
                        'roles' => ['@','?']
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

	public function actionTest()
    {
        VarDumper::dump(__METHOD__, 10, true);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->redirect(['/admin/app']);
		}

		$model = new UserForm([
		    'scenario' => UserForm::SCENARIO_LOGIN
        ]);

		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack(['/admin/app']);
		}

		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		if (Yii::$app->request->isAjax) {

		    Yii::$app->response->format = Response::FORMAT_JSON;

		    return [
		        'status' => 'ok'
            ];
        }

		return $this->redirect(['login']);
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

}
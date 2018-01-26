<?php
/**
 * Created by PhpStorm.
 * User: stephencozart
 * Date: 4/12/16
 * Time: 10:50 PM
 */

namespace app\modules\admin\controllers;


use app\interfaces\SearchServiceInterface;
use app\models\forms\UserForm;
use app\models\User;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\rest\Serializer;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class AppController extends Controller
{
    /**
     * @var SearchServiceInterface
     */
    protected $searchService;

    public function __construct($id, Module $module, SearchServiceInterface $searchService, array $config = [])
    {
        $this->searchService = $searchService;

        parent::__construct($id, $module, $config);
    }

    public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['login', 'logout', 'index', 'error', 'activate'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['login','activate'],
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
						'actions' => ['index','search'],
						'roles'=>['admin']
					]
				],
			],
		];
	}

    /**
     * @param $id
     * @param $key
     * @return string
     */
    public function actionActivate($id, $key)
    {
        /** @var User $user */
        $user = User::find()->where(['id' => $id])->andWhere(['activation_code' => $key])->one();

        if ($user === null) {

            throw new NotFoundHttpException();

        }

        $model = new UserForm(['scenario' => UserForm::SCENARIO_ACTIVATE]);

        if ($model->load(Yii::$app->request->post())) {

            $model->activation_code = $user->activation_code;

            $model->email = $user->email;

            if ($model->activate()) {

                Yii::$app->session->setFlash('success', 'Your user account is now activated.  You may now sign in.');

                $login = new UserForm(['scenario' => UserForm::SCENARIO_LOGIN]);

                $login->email = $user->email;

                $login->password = $model->password;

                if ($login->login()) {

                    return $this->redirect(['/admin']);

                } else {

                    return $this->redirect(['login']);

                }



            }
        }


        return $this->render('activate', ['model' => $model]);
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

	public function actionSearch($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $serializer = new Serializer([
            'collectionEnvelope' => 'items'
        ]);

        return $serializer->serialize($this->searchService->search($q));
    }

}
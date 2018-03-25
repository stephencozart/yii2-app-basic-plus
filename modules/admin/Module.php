<?php
/**
 * Created by PhpStorm.
 * User: stephencozart
 * Date: 4/12/16
 * Time: 10:58 PM
 */

namespace app\modules\admin;


use app\models\User;
use yii\base\Event;
use yii\helpers\Json;
use yii\web\View;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'app';

    public $layout = '@app/modules/admin/views/layouts/main';

    public $googleMapsApiKey;

    public function init()
    {
        \Yii::$app->errorHandler->errorAction = 'admin/app/error';

        if (\Yii::$app->user->isGuest === false) {

            $roles = [];

            foreach(\Yii::$app->authManager->getRoles() as $role) {
                $roles[] = $role;
            }

            $app = [
                'user'  => \Yii::$app->user->identity,
                'roles' => $roles
            ];

            $js = Json::encode($app);

            \Yii::$app->view->registerJs("window.app = $js;", View::POS_HEAD);

        }

        Event::on(User::class, User::EVENT_AFTER_INSERT, function(Event $event) {

            \Yii::$app->mailer->compose('user/activate', ['user' => $event->sender])
                ->setFrom(\Yii::$app->params['reply_to'])
                ->setTo($event->sender->email)
                ->setSubject('Activate Email')
                ->send();

        });

        if ($this->googleMapsApiKey) {
            \Yii::$app->view->registerJsFile("https://maps.googleapis.com/maps/api/js?key={$this->googleMapsApiKey}&libraries=places");
        }

        parent::init();
    }
}
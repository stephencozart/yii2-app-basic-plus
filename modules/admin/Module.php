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

    public function init()
    {
        \Yii::$app->errorHandler->errorAction = 'admin/app/error';

        if (\Yii::$app->user->isGuest === false) {

            $app = [
                'user' => \Yii::$app->user->identity
            ];

            $js = Json::encode($app);

            \Yii::$app->view->registerJs("window.app = $js;", View::POS_HEAD);

        }

        Event::on(User::className(), User::EVENT_AFTER_INSERT, function(Event $event) {
            \Yii::$app->mailer->compose('user/activate', ['user' => $event->sender])
                ->setFrom(\Yii::$app->params['reply_to'])
                ->setTo($event->sender->email)
                ->setSubject('Activate Email')
                ->send();
        });

        parent::init();
    }
}
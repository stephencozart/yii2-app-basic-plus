<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionCreateUser()
    {
        $firstName = $this->prompt('First Name:', ['required' => true]);

        $lastName = $this->prompt('Last Name:', ['required' => true]);

        $email = $this->prompt('Email:', ['required' => true]);

        $roleOptions = [];

        foreach(\Yii::$app->authManager->getRoles() as $role) {
            $roleOptions[$role->name] = $role->description ? $role->description : $role->name;
        }

        $roleOptions['none'] = 'None';

        $roles = $this->select('Role:', $roleOptions);

        var_dump($firstName, $lastName, $email, $roles);
    }
}

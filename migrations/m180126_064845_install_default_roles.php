<?php

use yii\db\Migration;

class m180126_064845_install_default_roles extends Migration
{
    public function safeUp()
    {
        $authManager = Yii::$app->authManager;

        $adminRole = $authManager->createRole('admin');
        $adminRole->description = 'Admin';
        $authManager->add($adminRole);

        $adminAccessPermission = $authManager->createPermission('admin-access');
        $adminAccessPermission->description = 'Allows general access to the admin';
        $authManager->add($adminAccessPermission);

        $authManager->addChild($adminRole, $adminAccessPermission);
    }

    public function safeDown()
    {
        Yii::$app->authManager->removeAllAssignments();
        Yii::$app->authManager->removeAllPermissions();
        Yii::$app->authManager->removeAllRoles();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180126_064845_install_default_roles cannot be reverted.\n";

        return false;
    }
    */
}

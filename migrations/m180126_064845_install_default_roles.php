<?php

use yii\db\Migration;

class m180126_064845_install_default_roles extends Migration
{
    protected $perms = [
      'admin-access' => 'Allows general access to the admin',
      'view-entries' => 'View Entries',
      'create-entries' => 'Create Entries',
      'update-entries' => 'Update Entries',
      'delete-entries' => 'Delete Entries'
    ];

    /**
     * @return bool|void
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $authManager = Yii::$app->authManager;

        $adminRole = $authManager->createRole('admin');
        $adminRole->description = 'Admin';
        $authManager->add($adminRole);

        foreach($this->perms as $permName => $permDescription) {

            $permission = $authManager->createPermission($permName);

            $permission->description = $permDescription;

            $authManager->add($permission);

            $authManager->addChild($adminRole, $permission);
        }

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

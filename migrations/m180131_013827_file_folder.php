<?php

use yii\db\Migration;

class m180131_013827_file_folder extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%file_collection}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(100)->notNull(),
            'name' => $this->string(100)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'deleted_at' => $this->dateTime()
        ]);

        $this->createIndex('idx_slug_unique', '{{%file_collection}}', ['slug','deleted_at'], true);
        $this->createIndex('idx_name', '{{%file_collection}}', ['name']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%file_collection}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180131_013827_file_folder cannot be reverted.\n";

        return false;
    }
    */
}

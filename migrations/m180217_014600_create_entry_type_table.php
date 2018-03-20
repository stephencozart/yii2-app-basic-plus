<?php

use yii\db\Migration;

/**
 * Handles the creation of table `entry_type`.
 */
class m180217_014600_create_entry_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%entry_type}}', [
            'id' => $this->primaryKey(),
            'handle' => $this->string(150),
            'enabled' => $this->boolean()->unsigned()->notNull()->defaultValue(1),
            'default_sort' => $this->string()->notNull()->defaultValue('-created_at'),
            'name' => $this->string(150),
            'content' => $this->text(),
            'items_per_page' => $this->integer()->unsigned()->notNull()->defaultValue(20),
            'meta_title' => $this->string(70),
            'meta_description' => $this->string(165),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime()
        ]);

        $this->createIndex('idxUniqueHandle','{{%entry_type}}', ['deleted_at','handle'], true);
        $this->createIndex('idxEnabled','{{%entry_type}}', ['deleted_at','enabled']);
        $this->createIndex('idxName','{{%entry_type}}', ['deleted_at','name']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%entry_type}}');
    }
}

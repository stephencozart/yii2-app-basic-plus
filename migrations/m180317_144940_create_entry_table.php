<?php

use yii\db\Migration;

/**
 * Handles the creation of table `entry`.
 */
class m180317_144940_create_entry_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%entry}}', [
            'id' => $this->primaryKey(),
            'is_master' => $this->boolean()->defaultValue(0),
            'entry_uid' => $this->string(64),
            'entry_type_id' => $this->integer()->unsigned()->notNull(),
            'entry_type_handle' => $this->string()->notNull(),
            'status' => $this->string(20)->notNull(),
            'title' => $this->string()->notNull(),
            'handle' => $this->string()->notNull(),
            'content' => $this->text(),
            'meta_title' => $this->string(),
            'meta_description' => $this->string(),
            'publish_at' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime()
        ]);

        $this->createIndex('typeHandleIdx', '{{%entry}}', ['entry_type_handle', 'deleted_at']);
        $this->createIndex('typeHandleStatusIdx', '{{%entry}}', ['entry_type_handle', 'status', 'deleted_at']);
        $this->createIndex('handleStatusIdx', '{{%entry}}', ['handle', 'status', 'deleted_at']);
        $this->createIndex('statusIdx', '{{%entry}}', ['status', 'deleted_at']);
        $this->createIndex('entryUidIdx', '{{%entry}}', ['entry_uid', 'deleted_at']);
        $this->createIndex('entryTypeIdx', '{{%entry}}', ['entry_type_id', 'deleted_at']);
        $this->createIndex('masterIdx', '{{%entry}}', ['is_master', 'deleted_at']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%entry}}');
    }
}

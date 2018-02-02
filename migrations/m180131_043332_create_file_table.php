<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file`.
 */
class m180131_043332_create_file_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'owner_type' => $this->string(100),
            'owner_id' => $this->string(100),
            'category' => $this->string(100),
            'name' => $this->string()->notNull(),
            'file_name' => $this->string()->notNull(),
            'mime_type' => $this->string(100),
            'file_size' => $this->integer()->unsigned()->defaultValue(0),
            'sort_order' => $this->integer()->unsigned()->defaultValue(0),
            'width' => $this->integer()->unsigned(),
            'height' => $this->integer()->unsigned(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime()
        ]);

        $this->createIndex('idx_owner', '{{%file}}', ['deleted_at', 'owner_type']);
        $this->createIndex('idx_owner_id', '{{%file}}', ['deleted_at','owner_type','owner_id']);
        $this->createIndex('idx_deleted', '{{%file}}', ['deleted_at']);
        $this->createIndex('idx_name', '{{%file}}', ['deleted_at','name']);
        $this->createIndex('idx_file_name', '{{%file}}', ['deleted_at','file_name']);
        $this->createIndex('idx_category', '{{%file}}', ['deleted_at','category']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%file}}');
    }
}

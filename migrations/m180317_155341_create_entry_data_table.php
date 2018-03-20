<?php

use yii\db\Migration;

/**
 * Handles the creation of table `entry_data`.
 */
class m180317_155341_create_entry_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%entry_data}}', [
            'id' => $this->primaryKey(),
            'entry_id' => $this->integer()->unsigned()->notNull(),
            'key' => $this->string()->notNull(),
            'value' => $this->text()
        ]);

        $this->createIndex('entryIdx', '{{%entry_data}}', ['entry_id','key'], true);
        $this->createIndex('filterIdx', '{{%entry_data}}', ['key']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%entry_data}}');
    }
}

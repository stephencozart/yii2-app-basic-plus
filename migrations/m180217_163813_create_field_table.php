<?php

use yii\db\Migration;

/**
 * Handles the creation of table `field`.
 */
class m180217_163813_create_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%field}}', [
            'id' => $this->primaryKey(),
            'entry_type_handle' => $this->string(150)->notNull(),
            'field_type_handle' => $this->string(100)->notNull(),
            'handle' => $this->string(100)->notNull(),
            'parent' => $this->string(100),
            'label' => $this->string(100),
            'required' => $this->boolean()->unsigned()->notNull()->defaultValue(0),
            'instructions' => $this->string(),
            'placeholder' => $this->string(100),
            'default_value' => $this->string(),
            'choices' => $this->text(),
            'min' => $this->integer(),
            'max' => $this->integer(),
            'step' => $this->string(),
            'pattern' => $this->string(),
            'searchable' => $this->boolean()->unsigned()->notNull()->defaultValue(0),
            'repeat_max' => $this->integer(),
            'prepend' => $this->string(),
            'append' => $this->string(),
            'position' => $this->integer()->unsigned()->notNull()->defaultValue(1000),
            'layout' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime()
        ]);

        $this->createIndex('idxEntryType', '{{%field}}', ['deleted_at', 'entry_type_handle', 'handle'], true);
        $this->createIndex('idxEntryTypeParent', '{{%field}}', ['deleted_at', 'parent']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%field}}');
    }
}

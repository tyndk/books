<?php

use yii\db\Migration;

/**
 * Class m240319_162534_create_table_comments
 */
class m240319_162534_create_table_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string(255)->notNull(),
            'book_id' => $this->integer(4)->notNull(),
            'user_id' => $this->integer(4)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240319_162534_create_table_comments cannot be reverted.\n";

        return false;
    }
    */
}

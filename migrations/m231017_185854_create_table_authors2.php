<?php

use yii\db\Migration;

/**
 * Class m231017_185854_create_table_authors2
 */
class m231017_185854_create_table_authors2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull() 
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231017_185854_create_table_authors2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231017_185854_create_table_authors2 cannot be reverted.\n";

        return false;
    }
    */
}

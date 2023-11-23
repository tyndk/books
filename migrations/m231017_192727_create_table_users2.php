<?php

use yii\db\Migration;
use yii\base\Security;

/**
 * Class m231017_192727_create_table_users2
 */
class m231017_192727_create_table_users2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $security = new Security();

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            //'auth_key' => $this->string(32)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231017_192727_create_table_users2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231017_192727_create_table_users2 cannot be reverted.\n";

        return false;
    }
    */
}

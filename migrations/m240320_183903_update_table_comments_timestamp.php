<?php

use yii\db\Migration;

/**
 * Class m240320_183903_update_table_comments_timestamp
 */
class m240320_183903_update_table_comments_timestamp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comments', 'timestamp', $this->timestamp()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('comments', 'timestamp');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240320_183903_update_table_comments_timestamp cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m231104_084315_update_table_books2
 */
class m231104_084315_update_table_books2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('books', 'year', $this->integer(4)->null());
        $this->alterColumn('books', 'image', $this->string(255)->null());
        $this->alterColumn('books', 'pages', $this->integer(3)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231104_084315_update_table_books2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231104_084315_update_table_books2 cannot be reverted.\n";

        return false;
    }
    */
}

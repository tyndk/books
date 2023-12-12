<?php

use yii\db\Migration;

/**
 * Class m231115_170150_update_table_books_image
 */
class m231115_170150_update_table_books_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('books', 'thumbnail', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //echo "m231115_170150_update_table_books_image cannot be reverted.\n";
        $this->dropColumn('books', 'thumbnail');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231115_170150_update_table_books_image cannot be reverted.\n";

        return false;
    }
    */
}

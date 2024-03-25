<?php

use yii\db\Migration;

/**
 * Class m240319_072854_update_books_text
 */
class m240319_072854_update_books_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('books', 'text', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('books', 'text');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240319_072854_update_books_text cannot be reverted.\n";

        return false;
    }
    */
}

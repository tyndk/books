<?php

use yii\db\Migration;

/**
 * Class m231017_185946_create_table_books2
 */
class m231017_185946_create_table_books2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(4)->notNull(),
            'title' => $this->string(255)->notNull(),
            'year' => $this->integer(4)->null(),
            'genre' => $this->string(255)->notNull(),
            'image' => $this->string(255)->null(),
            'pages' => $this->integer(3)->null()
        ]);

        $this->addForeignKey(
            'fk-books-author_id',
            'books',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231017_185946_create_table_books2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231017_185946_create_table_books2 cannot be reverted.\n";

        return false;
    }
    */
}

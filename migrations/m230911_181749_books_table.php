<?php

use yii\db\Migration;

/**
 * Class m230911_181749_books_table
 */
class m230911_181749_books_table extends Migration
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
            'year' => $this->integer(4)->notNull(),
            'genre' => $this->string(255)->notNull(),
            'image' => $this->string(255)->notNull(),
            'pages' => $this->integer(3)->notNull()
        ]);

        $this->addForeignKey(
            'fk-books-author_id',
            'books',
            'author_id',
            'author',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230911_181749_books_table cannot be reverted.\n";
        $this->dropTable('{{%books}}');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230911_181749_books_table cannot be reverted.\n";

        return false;
    }
    */
}

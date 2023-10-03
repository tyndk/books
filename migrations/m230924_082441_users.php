<?php

use app\models\RegistrationForm;
use yii\base\Security;
use yii\db\Migration;

/**
 * Class m230924_082441_users
 */
class m230924_082441_users extends Migration
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
            'auth_key' => $this->string(32)->notNull(),
        ]);

        $model = new RegistrationForm();
        $passwordHash = $security->generatePasswordHash($model->password);

        $this->insert('users', [
           'username' => $model->username,
           'email' => $model->email,
           'password' => $passwordHash,
           'auth_key' => Yii::$app->security->generateRandomString(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230924_082441_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230924_082441_users cannot be reverted.\n";

        return false;
    }
    */
}

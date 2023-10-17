<?php

use yii\db\Migration;
use app\models\RegistrationForm;

/**
 * Class m231017_191526_add_table_users2
 */
class m231017_191526_add_table_users2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
        echo "m231017_191526_add_table_users2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231017_191526_add_table_users2 cannot be reverted.\n";

        return false;
    }
    */
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Этот email занят.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save()) {
                return true;
            }
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Никнейм',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}
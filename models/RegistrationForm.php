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
            ['email', 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email', 'message' => 'Этот email занят.'],
            ['password', 'string', 'min' => 6],
            ['username', 'filter', 'filter' => function($value){
                return strip_tags($value);
            }],
        ];
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
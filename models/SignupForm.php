<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $login;
    public $password;
    public $email;
    public $phone;

    public function rules()
    {
        return [
            [['login', 'password', 'email', 'phone'], 'required'],
            [['login', 'password', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^\+?[0-9]{10,15}$/', 'message' => 'Phone number must be between 10 and 15 digits, and can start with a +'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Email',
            'phone' => 'Телефон',
        ];
    }
}

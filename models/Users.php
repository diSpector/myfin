<?php

namespace app\models;

use Yii;
use app\models\base\UsersBase;
use yii\web\IdentityInterface;

class Users extends UsersBase implements IdentityInterface
{
    public $password;
    public $passwordRepeat;

    public $username;

    public function rules()
    {
        return array_merge(
            [
                // ['password', 'string', 'min' => 4, 'message' => 'Поле {attribute} должно содержать как минимум 4 цифры'],
                [['password'], 'required', 'message' => 'Поле "{attribute}" не может быть пустым'],
                [['password'], 'string', 'min'=> 4, 'message' => 'Пароль слишком короткий'],
                ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
                ['email', 'email', 'message' => 'В поле "{attribute}" должен быть действительный адрес email']
            ],
            parent::rules()
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            [
                'password' => 'Введите пароль',
                'passwordRepeat' => 'Повторите пароль',
            ],
            parent::attributeLabels()
        );
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['access_token' => $token]);
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // return $this->authKey;
        return null;
    }

    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
        return null;
    }
}

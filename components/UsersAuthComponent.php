<?php

namespace app\components;

use Yii;
use app\models\Users;
use yii\base\Component;

class UsersAuthComponent extends Component
{
    public function getModel($params = null)
    {
        $model = new Users($params);

        return $model;
    }

    public function createUser(&$model)
    {
        $model->password_hash = $this->generateHashForPassword($model->password);
        if ($model->save()) {
            $auth = \Yii::$app->authManager;
            $auth->assign($auth->getRole('user'), $model->id);
            return true;
        }

        return false;
    }

    public function loginUser(&$model)
    {
        $user = $this->getUserByEmail($model->email);
        if (!$user) {
            Yii::$app->session->setFlash('error', 'Такого пользователя не существует');
            return false;
        }
        if (!$this->validatePassword($model->password, $user->password_hash)) {
            return false;
        }
        $user->username = $user->email;
        Yii::$app->user->login($user);

        return true;
    }

    private function generateHashForPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    private function getUserByEmail($email)
    {
        return $this->getModel()::find()->andWhere(['email' => $email])->one();
    }

    private function validatePassword($password, $hash)
    {
        return \Yii::$app->security->validatePassword($password, $hash);
    }
}

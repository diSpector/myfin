<?php 

namespace app\controllers\actions\auth;

use Yii;
use yii\base\Action;

class LogoutAction extends Action
{
    public function run()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Выполнен выход');
        return $this->controller->redirect('/site/index');
    }
}
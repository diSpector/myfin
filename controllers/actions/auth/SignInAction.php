<?php 

namespace app\controllers\actions\auth;

use Yii;
use yii\base\Action;

class SignInAction extends Action
{
    public function run()
    {
        $comp = Yii::$app->auth;
        $model = $comp->getModel();

        if($model->load(Yii::$app->request->post())){
            if($comp->loginUser($model)){
                Yii::$app->session->setFlash('success', 'Вы вошли как ' . $model->email);
                // return $this->controller->redirect('/site/index');
                // return $this->controller->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                // return $this->controller->goBack(Yii::$app->request->referrer);
                // return $this->controller->goBack(Yii::$app->request->referrer);
                return $this->controller->goBack();
            } else {
                Yii::$app->session->setFlash('error', 'Логин или пароль неправильный. Авторизация не удалась');
            }
        }

        return $this->controller->render('sign-in', ['model' => $model]);
    }
}
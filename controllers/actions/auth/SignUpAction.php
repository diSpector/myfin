<?php 

namespace app\controllers\actions\auth;

use Yii;
use yii\base\Action;

class SignUpAction extends Action
{
    public function run()
    {
        // Yii::$app->user->logout();
        // компонент пользователя
        $comp = Yii::$app->auth;
        
        // модель пользователя из компонента
        $model = $comp->getModel();
        
        if($model->load(Yii::$app->request->post()) && $model->validate()){

            if($comp->createUser($model)){ 
                if($comp->loginUser($model)){
                    Yii::$app->session->addFlash('success', 'Вы успешно зарегистрировались как ' . $model->email);
                    return $this->controller->redirect('/site/index');
                } else {
                    Yii::$app->session->setFlash('error', 'Авторизация не удалась, такого пользователя не существует');                    
                }
            } else {
                Yii::$app->session->setFlash('error', 'Создать нового пользователя не удалось!');
            }
        }
        
        return $this->controller->render('sign-up', ['model' => $model]);
    }
}
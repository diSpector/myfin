<?php

namespace app\base;

use yii\web\Controller;
use Yii;
use yii\helpers\Url;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        Url::remember();
        if(Yii::$app->user->isGuest){
            return $this->redirect('/auth/sign-in');
        }
        
        return parent::beforeAction($action);
    }
}

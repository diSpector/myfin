<?php

namespace app\controllers\actions\sources;

use Yii;
use yii\base\Action;

class ViewSourceAction extends Action
{
    public function run()
    {
        $comp = Yii::$app->sources;
        $userId = Yii::$app->user->id;
        $categories = $comp->getSearchProvider(['user_id' => $userId]);
        
        return $this->controller->render('view', ['dataProvider' => $categories]);

    }
}

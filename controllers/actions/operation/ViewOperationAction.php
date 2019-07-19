<?php

namespace app\controllers\actions\operation;

use app\components\OperationComponent;
use Yii;
use yii\base\Action;

class ViewOperationAction extends Action
{
    public function run()
    {
      /** @var OperationComponent $comp */
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;
        $filterModel = $comp->getOperationSearch();
        $operations = $comp->getSearchProvider($userId, Yii::$app->request->get());

        // определяем видимость виджета по наличию у пользователя категорий и источников
        $categories = $comp->getUserCategories($userId);
        $sources = $comp->getUserSources($userId);
        $isVisible = $categories && $sources;

        if(!$isVisible){
            return $this->controller->render('error');
        }

        return $this->controller->render('view', [
            'dataProvider' => $operations,
            'filterModel' => $filterModel,
            'isVisible' => $isVisible
        ]);
    }
}

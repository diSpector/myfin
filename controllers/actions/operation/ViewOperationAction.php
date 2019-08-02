<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use ViewOperationTestAction;
use app\components\OperationComponent;

class ViewOperationAction extends Action
{
    public function run()
    {
      /** @var OperationComponent $comp */
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;
        $filterModel = $comp->getOperationSearch();
        $operations = $comp->getSearchProvider($userId, Yii::$app->request->get());

        
        
        $dates = $comp->getAllDatesPicked($userId);
        // echo "Даты";
        // var_dump($dates);

        // получить массив всех операций по дням
        $operationsArrayByDate = [];
        foreach($dates as $date=>$value){
            $operationsArrayByDate[$value] = $comp->getOperationsByDate($value);
        }
        // echo "операции";

        // var_dump($operationsArrayByDate);

        // определяем видимость виджета по наличию у пользователя категорий и источников
        $categories = $comp->getUserCategories($userId);
        $sources = $comp->getUserSources($userId);
        $isVisible = $categories && $sources;

        if(!$isVisible){
            return $this->controller->render('error');
        }

        // return $this->controller->render('view', [
        //     'dates' => $dates,
        //     'dataProvider' => $operations,
        //     'filterModel' => $filterModel,
        //     'isVisible' => $isVisible
        // ]);

        return $this->controller->render('view_test', [
            'dates' => $dates,
            'dataProvider' => $operations,
            'filterModel' => $filterModel,
            'isVisible' => $isVisible,
            'operationsArrayByDate' => $operationsArrayByDate,
        ]);
    }
}

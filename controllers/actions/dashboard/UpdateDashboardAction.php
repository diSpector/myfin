<?php

namespace app\controllers\actions\dashboard;

use Yii;
use yii\base\Action;
use app\components\DashboardComponent;

class UpdateDashboardAction extends Action
{
    public function run()
    {
        $userId = Yii::$app->user->id;
        $request = Yii::$app->request;
        $categoryId = $request->get('categoryId');
        $date = $request->get('date');
        $dates = $request->get('dates');

        /** @var DashboardComponent $dashboardComp */
        $dashboardComp = Yii::$app->dashboard;

        if (isset($date)){
            $operations = $dashboardComp->getCategoryOperationsByDay($userId, $categoryId, $date);
            $operationsForView = $dashboardComp->addIndexOperations($operations, $date);
        }

        if (isset($dates)){
            $operations = $dashboardComp->getCategoryOperationsByPeriod($userId, $categoryId, $dates);
            $operationsForView = $dashboardComp->addIndexOperations($operations, $dates);
        }

        return $this->controller->render('update', [
            'operations' => $operationsForView,
        ]);


    }
}
<?php

namespace app\controllers\actions\dashboard;

use Yii;
use yii\base\Action;
use app\components\DashboardComponent;
use app\components\OperationComponent;
use app\components\DateRangeFormComponent;

class ViewDashboardAction extends Action
{
    const COUNT_DATES = 3;

    public function run()
    {
        $userId = Yii::$app->user->id;
        /** @var OperationComponent $operationComp */
        $operationComp = Yii::$app->operation;;
        $balance = $operationComp->getTotalBalance($userId);

        /** @var DashboardComponent $dashboardComp  */
        $dashboardComp = Yii::$app->dashboard;

        /** @var DateRangeFormComponent $dateRangeComp */
        $dateRangeComp = Yii::$app->dateRangeForm;
        $formRangeModel = $dateRangeComp->getModel();

        if (Yii::$app->request->isPost) {
            // получить данные из post - range (дата начала - дата конца) и period (0 - итого, 1 - за каждый день)
            $formRangeModel->load(Yii::$app->request->post());
            $dateRange = explode(' - ', $formRangeModel->dateRange);
            $allGrouped = $dashboardComp->getSummary($userId, $dateRange, $formRangeModel->period);    

            // если пришел period = 1 (показать операции за каждый день), нужно сделать реиндекс, иначе - добавить индекс с периодом                           
            if($formRangeModel->period){
                $allGrouped = $dashboardComp->reIndexOperations($allGrouped);
            } else {
                $allGrouped = $dashboardComp->addIndexOperations($allGrouped, $formRangeModel->dateRange);
            }

            // $reindexedAllGrouped = $dashboardComp->reIndexOperations($allGrouped);
            $title = 'Показаны операции по категориям за период ' . $formRangeModel->dateRange;

            return $this->controller->render('view', [
                'title' => $title,
                // 'allGrouped' => $reindexedAllGrouped,
                'allGrouped' => $allGrouped,
                'balance' => $balance,
                'formRangeModel' => $formRangeModel,
            ]);
        }

        $dateToday = date('Y-m-d');
        $dateBeforeYesteray = date('Y-m-d', strtotime($dateToday . ' -2 days'));     
        $allGrouped = $dashboardComp->getSummary($userId, [$dateBeforeYesteray, $dateToday], true);
        $reindexedAllGrouped = $dashboardComp->reIndexOperations($allGrouped);
        $title = 'Показаны операции по категориям за последние 3 дня';

        return $this->controller->render('view', [
            'title' => $title,
            'allGrouped' => $reindexedAllGrouped,
            'balance' => $balance,
            'formRangeModel' => $formRangeModel
        ]);
    }
}

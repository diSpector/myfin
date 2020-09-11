<?php

namespace app\controllers\actions\dashboard;

use Yii;
use yii\base\Action;
use app\components\DashboardComponent;
use app\components\OperationComponent;
use app\components\DateRangeFormComponent;

class ViewTestDashboardAction extends Action
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

        // если пришел Ajax-запрос - показать отчет за период
        if (Yii::$app->request->isAjax) { 
            $data = Yii::$app->request->post();
            $dates = $data['dates'];
            $period = $data['period'];

            // валидация входных параметров
            $datesRegExp = '/^((?:19|20)\d{2})\-(1[012]|0?[1-9])\-(3[01]|[12][0-9]|0?[1-9])\s-\s((?:19|20)\d{2})\-(1[012]|0?[1-9])\-(3[01]|[12][0-9]|0?[1-9])$/';
            $periodArr = ['0', '1'];
            
            // если во входных параметрах ошибка, сообщить об этом
            if (!preg_match($datesRegExp, $dates) || !in_array($period, $periodArr)){
                return $this->controller->renderAjax('_error');
            }

            $dateRange = explode(' - ', $dates);
            $allGrouped = $dashboardComp->getSummary($userId, $dateRange, $period);    

            // если пришел period = 1 (показать операции за каждый день), нужно сделать реиндекс, иначе - добавить индекс с периодом                           
            if($period){
                $allGrouped = $dashboardComp->reIndexOperations($allGrouped);
            } else {
                $allGrouped = $dashboardComp->addIndexOperations($allGrouped, $dates);
            }

            $title = 'Показаны операции по категориям за период ' . $dates;

            return $this->controller->renderAjax('_loaded-data', [
                'title' => $title,
                'allGrouped' => $allGrouped,
            ]);
        }

        $dateToday = date('Y-m-d');
        $dateBeforeYesteray = date('Y-m-d', strtotime($dateToday . ' -2 days'));
        $allGrouped = $dashboardComp->getSummary($userId, [$dateBeforeYesteray, $dateToday], true);
        $reindexedAllGrouped = $dashboardComp->reIndexOperations($allGrouped);
        $title = 'Показаны операции по категориям за последние 3 дня';

        return $this->controller->render('view_test', [
            'title' => $title,
            'allGrouped' => $reindexedAllGrouped,
            'balance' => $balance,
            'formRangeModel' => $formRangeModel
        ]);
    }
}

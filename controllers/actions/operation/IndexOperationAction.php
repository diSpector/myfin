<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use app\components\OperationComponent;
use app\components\DateRangeFormComponent;

class IndexOperationAction extends Action
{
    const OFFSET = 0;
    const COUNT = 10;

    public function run()
    {
        /** @var OperationComponent $comp */
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;

        /** @var DateRangeFormComponent $dateRangeComp */
        $dateRangeComp = Yii::$app->dateRangeForm;
        $dateRangeModel = $dateRangeComp->getModel();

        // используем сценарий 'operation', в котором валидироваться должен только dateRange
        $dateRangeModel->scenario = 'operation'; 

        $balance = $comp->getTotalBalance($userId);

        if ( Yii::$app->request->isAjax ) {
            $data = Yii::$app->request->post();
            if (isset($data['offset'])){
                $offset = $data['offset'];

                $operations = $comp->getOperations($userId, $offset, self::COUNT);
                $operationsForView = $comp->reIndexOperations($operations);
    
                return $this->controller->renderAjax('_loaded-data', [
                    'operations' => $operationsForView,
                    'offset' => $offset + self::COUNT,
                    'count' => self::COUNT,
                ]);
            }

            if (isset($data['dates'])){
                $datesArr = explode(' - ', $data['dates']);
                $operations = $comp->getOperationsForPeriod($userId, $datesArr);
                $operationsForView = $comp->reIndexOperations($operations);
                
                return $this->controller->renderAjax('_loaded-data', [
                    'operations' => $operationsForView,
                    // 'offset' => $offset + self::COUNT,
                    // 'count' => self::COUNT,
                ]);

            }
        }

        // общее число операций пользователя - записывается в hiddenInput
        $totalOperations = $comp->howManyOperations($comp->getOperations($userId));

        // первичная инициализация 
        $operations = $comp->getOperations($userId, self::OFFSET, self::COUNT);
        $operationsForView = $comp->reIndexOperations($operations);

        return $this->controller->render('index', [
            'operations' => $operationsForView,
            'dateRangeModel' => $dateRangeModel,
            'newOffset' => self::OFFSET + self::COUNT,
            'count' => self::COUNT,
            'totalOperations' => $totalOperations,
            'balance' => $balance,
        ]);
        // return $this->controller->render('index');
    }
}
<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use app\components\OperationComponent;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ViewOperationTestAction extends Action
{
    public function run()
    {
        /** @var OperationComponent $comp */
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;

        $tillDate = date('Y-m-d', strtotime(date('Y-m-d') . " -1 month"));
        $toDate = date('Y-m-d');

        $offset = 0;
        $count = 10;
        // $operations = $comp->getAllOperationsForUser($userId, $tillDate, $toDate);
        $operations = $comp->getLastOperations($userId, $offset, $count);

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $newTillDate = $data['newStartDate'];
            $newToDate = $data['newStopDate'];
            // $operations = $comp->getAllOperationsForUser($userId, $newTillDate, $newToDate);
            $operations = $comp->getLastOperations($userId, $newToDate);

            return $this->controller->renderAjax('_loaded-data', [
                'operationsByDate' => $operations,
                'tillDate' => $newTillDate,
            ]);
        }

        return $this->controller->render('view_test', [
            'operationsByDate' => $operations,
            // 'tillDate' => $tillDate,
            'offset' => $offset,
            'count' => $count,

        ]);
    }
}

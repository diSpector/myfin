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

        // вывод под датам уже не используется
        // $tillDate = date('Y-m-d', strtotime(date('Y-m-d') . " -1 month"));
        // $toDate = date('Y-m-d');
        $more = true;
        $offset = 0;
        $count = 3;
        // $operations = $comp->getAllOperationsForUser($userId, $tillDate, $toDate);
        $operations = $comp->getOperations($userId, $offset, $count);
        $indexedOperations = $comp->reIndexOperations($operations);
        $howManyOperations = $comp->howManyOperations($operations);
        if ($howManyOperations < $count) {
            $more = false;
        }
        // $operations = $comp->getLastOperations($userId, $offset, $count);


        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            // $newTillDate = $data['newStartDate'];
            // $newToDate = $data['newStopDate'];
            $offset = $data['offset'];
            $count = $data['count'];
            // $operations = $comp->getAllOperationsForUser($userId, $newTillDate, $newToDate);
            // $operations = $comp->getLastOperations($userId, $offset, $count);

            $operations = $comp->getOperations($userId, $offset, $count);
            $indexedOperations = $comp->reIndexOperations($operations);
            $howManyOperations = $comp->howManyOperations($operations);

            if ($howManyOperations < $count) {
                $more = false;
            }

            return $this->controller->renderAjax('_loaded-data', [
                'operationsByDate' => $indexedOperations,
                'offset' => $offset + $count,
                'count' => $count,
                'more' => $more
            ]);
        }

        return $this->controller->render('view_test', [
            'operationsByDate' => $indexedOperations,
            'offset' => $offset + $count,
            'count' => $count,
            'more' => $more
        ]);
    }
}

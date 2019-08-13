<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use app\components\OperationComponent;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ViewOperationTestAction extends Action
{
    const OFFSET = 0;
    const COUNT = 10;

    public function run()
    {
        /** @var OperationComponent $comp */
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;

        $balance = $comp->getTotalBalance($userId);

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $offset = $data['offset'];

            $operations = $comp->getOperations($userId, $offset, self::COUNT);
            $operationsForView = $comp->reIndexOperations($operations);

            return $this->controller->renderAjax('_loaded-data', [
                'operations' => $operationsForView,
                'offset' => $offset + self::COUNT,
                'count' => self::COUNT,
            ]);
        }

        // общее число операций пользователя - записывается в hiddenInput
        $totalOperations = $comp->howManyOperations($comp->getOperations($userId));

        // первичная инициализация 
        $operations = $comp->getOperations($userId, self::OFFSET, self::COUNT);
        $operationsForView = $comp->reIndexOperations($operations);

        return $this->controller->render('view_test', [
            'operations' => $operationsForView,
            'newOffset' => self::OFFSET + self::COUNT,
            'count' => self::COUNT,
            'totalOperations' => $totalOperations,
            'balance' => $balance,
        ]);
    }
}

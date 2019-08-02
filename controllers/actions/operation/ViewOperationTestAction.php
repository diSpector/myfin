<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use app\components\OperationComponent;
use yii\helpers\ArrayHelper;

class ViewOperationTestAction extends Action
{
    public function run()
    {
      /** @var OperationComponent $comp */
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;

        $operations = $comp->getAllOperationsForUser($userId);

        return $this->controller->render('view_test', [
            'operationsByDate' => $operations,
        ]);
    }
}

<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\OperationType;
use yii\helpers\ArrayHelper;

class OperationTypeComponent extends Component
{
    public function getModel()
    {
        return ArrayHelper::map(OperationType::find()->all(), 'id', 'name');
    }
}

<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\OperationForm;
use yii\helpers\ArrayHelper;

class OperationFormComponent extends Component
{
    public function getModel()
    {
        return ArrayHelper::map(OperationForm::find()->all(), 'id', 'name');
    }
}

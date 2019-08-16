<?php

namespace app\components;

use yii\base\Component;
use app\models\DateRangeForm;

class DateRangeFormComponent extends Component
{
    public function getModel()
    {
        return new DateRangeForm();
    }
}
<?php

namespace app\widgets\OperationByDayWidget;

use yii\base\Widget;
use yii\helpers\Html;

class OperationByDayWidget extends Widget
{
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render(
            'widgetlayout',
            [
                'models' => $this->model,
            ]
        );
    }
}

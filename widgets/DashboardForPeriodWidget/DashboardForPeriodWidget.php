<?php

namespace app\widgets\DashboardForPeriodWidget;

use yii\base\Widget;
use yii\helpers\Html;

class DashboardForPeriodWidget extends Widget
{
    public $model;
    public $title;


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
                'title' => $this->title,
            ]
        );
    }
}

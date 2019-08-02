<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class OperationByDayWidget extends Widget
{
    public $model;

    public function init()
    {
        parent::init();
        // if ($this->text === null) {
        //     $this->text = 'Элемент списка';
        // }
    }

    public function run()
    {
        echo $this->model[0]['date_picked'];
        Html::beginTag('table');
        foreach ($this->model as $model => $value) {

                echo $value['id'] . '<br>';
                echo $value['sum'] . '<br>';
                echo $value['name'] . '<br>';
            }
        // return Html::a($this->text, '', ['class' => 'link-default-category']);
    }
}
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
        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
        foreach ($this->model as $model => $value) {

                echo $value['id'] . '<br>';
                echo $value['sum'] . '<br>';
                echo $value['name'] . '<br>';
            }
        // return Html::a($this->text, '', ['class' => 'link-default-category']);
    }
}
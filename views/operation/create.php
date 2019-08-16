<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

?>

<div class="row">
    <div class="col-md-offset-3 col-md-6">

        <h1>Новая операция</h1>
        <?= Html::label('Тип операции', 'types') ?>
        <?= Html::dropDownList('types', null, $types, [
            'prompt' => 'Выберите тип из списка',
            'class' => 'form-control',
            'id' => 'operation-type'
        ]) ?>

        <div id="operation_info">
        </div>
        <br>
        <br>
        <?= Html::a('Назад к списку операций', ['/operation/view'], ['class' => 'badge badge-light']) ?>
        <br>
        <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
    </div>
</div>
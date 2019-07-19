<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h1>Создание нового источника</h1>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'total'); ?>
        <?= $form->field($model, 'type')->dropDownList($types); ?>
    
        <div class="col-lg-12">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php $form->end(); ?>
        
        <?= Html::a('Назад к списку источников', ['/sources/view'], ['class' => 'badge badge-light']) ?>
        <br>
        <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
    </div>
</div>
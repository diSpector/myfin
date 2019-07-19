<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h1>Изменение источника</h1>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')->input(''); ?>
        <?= $form->field($model, 'total')->input(''); ?>            
        <?= $form->field($model, 'type')->dropDownList($types); ?>

            <div class="col-lg-12">
                <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php $form->end(); ?>
        <br>
        <br>

        <?= Html::a('Назад к источникам', ['/sources/view'], ['class' => 'badge badge-light']) ?>
        <br>
        <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
    </div>
</div>
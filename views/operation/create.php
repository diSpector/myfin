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

        <div id="operation_info" style="display: none;">
            <?php $form = ActiveForm::begin(['id' => 'operation-form']); ?>
            <?= $form->field($model, 'type', [
                'inputOptions' => [
                    'id' => 'selected-operation-type',
                    'class' => 'form-control',
                ]
            ])->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'sum'); ?>
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'source_id')->dropDownList($sources, ['prompt' => 'Выберите источник']); ?>
            <?= $form->field($model, 'category_id')->dropDownList($categories, [
                'prompt' => 'Выберите категорию',
            ]); ?>
            <div class="col-lg-12">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php $form->end(); ?>

        <br>
        <br>
        <br>

        <?= Html::a('Назад к списку операций', ['/operation/view'], ['class' => 'badge badge-light']) ?>
        <br>
        <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h1>Редактирование операции</h1>

        <?php $form = ActiveForm::begin(['id' => 'operation-form']); ?>
        <?= $form->field($model, 'type', [
            'inputOptions' => [
                'id' => 'selected-operation-type',
                'class' => 'form-control',
            ]
        ])->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'sum'); ?>
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'source_id')->dropDownList($sources, [
            'prompt' => 'Выберите источник'
        ]); ?>
        <?= $form->field($model, 'category_id')->dropDownList($categories, [
            'prompt' => 'Выберите категорию',
        ]); ?>
        <?= $form->field($model, 'date_picked')->widget(\yii\jui\DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' =>
            [
                'class' => ['form-control'],
            ],
        ]); ?>
        <div class="col-lg-12">
            <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton(
                'Удалить',
                [
                    'class' => 'btn btn-danger',
                    'name' => 'button',
                    'value' => 'delete',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить операцию?'
                    ]
                ]
            ) ?>

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
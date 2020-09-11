<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['id' => 'operation-form']); ?>
<?= $form->field($model, 'type', [
    'inputOptions' => [
        'id' => 'selected-operation-type',
        'class' => 'form-control',
    ]
])->hiddenInput(['value' => $selectedType])->label(false); ?>
<?= $form->field($model, 'sum'); ?>
<?= $form->field($model, 'source_id')->dropDownList($sources, ['prompt' => 'Выберите источник']); ?>
<?= $form->field($model, 'source_id2')->dropDownList($sources, ['prompt' => 'Выберите источник']); ?>
<i>Нет нужного источника? <?= Html::a('Добавить', ['sources/create'], ['class' => 'profile-link']) ?></i><br><br>

<?= $form->field($model, 'date_picked')->widget(\yii\jui\DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options' =>
    [
        'class' => ['form-control'],
    ],
]); ?>
<div class="col-lg-12">
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
</div>
<?php $form->end(); ?>
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\widgets\DashboardForPeriodWidget\DashboardForPeriodWidget;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-md-12">
        <h1 class='text-center'>Dashboard</h1>
        <div class="balance text-right">
            <?php foreach ($balance as $balanceSource) : ?>
                <h4>Баланс на "<?= $balanceSource['name'] ?>": <?= $balanceSource['balance'] ?></h4>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-md-offset-8">
        <!-- <h4 class="text-right"><label class="control-label">Выберите период:</label></h4> -->
        <?php $form = ActiveForm::begin(); ?>
        <div class="drp-container">
            <?php echo $form->field($formRangeModel, 'dateRange', [
                'options' => ['class' => 'drp-container form-group']
            ])->widget(DateRangePicker::classname(), [
                'name' => 'date_range_2',
                'presetDropdown' => true,
                'hideInput' => true,
                'convertFormat' => true,
                'pluginOptions' => [
                    'opens' => 'right',
                    'locale' => [
                        'cancelLabel' => 'Clear',
                        'format' => 'Y-m-d',
                    ]
                ]
            ]);
            ?>
        </div>
        <?= $form->field($formRangeModel, 'period')->dropDownList([
            '0' => 'Итого',
            '1' => 'За каждый день',
        ]); ?>

        <div class="col-lg-12">
            <?= Html::submitButton('Показать', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php $form->end(); ?>
    </div>
</div>

<br>
<br>

<div class="row">
    <div class="col-md-12">
        <div class="dashboard-area">

            <?php if (count($allGrouped) !== 0) : ?>
                <h2 class='text-center'><?= $title ?></h1>

                    <?php foreach ($allGrouped as $date => $operations) : ?>
                        <?= DashboardForPeriodWidget::widget(['title' => $date, 'model' => $operations]) ?>
                    <? endforeach; ?>

                <?php else : ?>
                    <h4 class="text-center">Операций нет</h4>
                <?php endif; ?>
        </div>
    </div>
</div>

<div class="buttons-area-bottom text-center">
    <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
</div>
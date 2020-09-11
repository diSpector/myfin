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
        <label class="control-label">Выберите период</label>
        <div class="drp-container">
            <?= DateRangePicker::widget([
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
        <br>

        <label class="control-label">Способ</label>
        <div class="form-group">
            <?= Html::dropDownList(
                'period',
                null,
                [
                    0 => 'Итого',
                    1 => 'За каждый день',
                ],
                ['class' => 'form-control']

            ); ?>
        </div>

        <div class="dashboard-ajax-buttons">
            <?= Html::tag('p', 'Показать', ['class' => 'btn btn-primary']) ?>
        </div>


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
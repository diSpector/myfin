<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use app\widgets\OperationByDayWidget\OperationByDayWidget;

?>

<div class="row">
    <div class="col-md-12">
        <h1 class='text-center'>Операции</h1>
        <div class="buttons-area-top text-right">
            <?= Html::a('Добавить', ['/operation/create/'], ['class' => 'btn btn-primary']); ?>
        </div>
        <div class="balance text-right">
            <?php foreach ($balance as $balanceSource) : ?>
                <h4>Баланс на "<?= $balanceSource['name'] ?>": <?= $balanceSource['balance'] ?></h4>
            <?php endforeach; ?>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-8">
                <!-- <h4 class="text-right"><label class="control-label">Выберите период:</label></h4> -->
                <?php $form = ActiveForm::begin([
                    'id' => 'operation-daterange-form',
                    'enableAjaxValidation' => true,
                    'validationUrl' => '/operation/validate',
                ]); ?>
                <div class="drp-container">
                    <?php echo $form->field($dateRangeModel, 'dateRange', [
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

                <div class="col-lg-12">
                    <?= Html::submitButton('Показать', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php $form->end(); ?>
            </div>
        </div>


        <div class="operations-area">
            <?php if (count($operations) !== 0) :  ?>
                <?php foreach ($operations as $date => $operationBlock) : ?>
                    <?= OperationByDayWidget::widget(['title' => $date, 'model' => $operationBlock]) ?>
                <?php endforeach; ?>
            <?php else : ?>
                <h4 class="text-center">Операций нет</h4>
                <?php if (Yii::$app->request->queryParams) : ?>
                    <?= Html::a('Сбросить фильтры', '/operation/view'); ?>
                    <br>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if ($newOffset < $totalOperations) : ?>
            <div class="buttons-load-more text-center">
                <?= Html::tag('p', 'Загрузить еще', ['class' => 'btn btn-success']) ?>
                <?= Html::hiddenInput('attrs', '', ['data-count' => $count, 'data-total' => $totalOperations, 'data-offset' => $newOffset]); ?>
            </div>
        <?php endif; ?>
        <br>
        <br>
        <div class="buttons-area-bottom text-center">
            <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
        </div>
    </div>
</div>
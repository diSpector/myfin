<?php

use yii\helpers\Html;
use app\widgets\OperationByDayWidget\OperationByDayWidget;

?>


<div class="row">
    <div class="col-md-12">
        <h1 class='text-center'>Операции</h1>
        <div class="buttons-area-top text-right">
            <?= Html::a('Добавить', ['/operation/create/'], ['class' => 'btn btn-primary']); ?>
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
        <br>
        <br>
        <div class="buttons-area-bottom text-center">
            <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
        </div>
    </div>
</div>
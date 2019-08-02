<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use app\models\OperationForm;
use app\models\OperationType;
use app\widgets\OperationByDayWidget\OperationByDayWidget;
?>

<div class="row">
    <div class="col-md-12">
        <h1 class='text-center'>Операции</h1>
        <div class="buttons-area-top text-right">
            <?= Html::a('Добавить', ['/operation/create/'], ['class' => 'btn btn-primary']); ?>
        </div>
        <div class="operations-area">
            <?php if (count($operationsByDate) !== 0) :  ?>
                <?php foreach ($operationsByDate as $operation) : ?>
                    <?= OperationByDayWidget::widget(['model' => $operation]) ?>
                <?php endforeach; ?>
            <?php else : ?>
                <h4 class="text-center">Операций нет</h4>
                <?php if (Yii::$app->request->queryParams) : ?>
                    <?= Html::a('Сбросить фильтры', '/operation/view'); ?>
                    <br>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if ($more) : ?>
            <div class="buttons-load-more text-center">
                <?= Html::tag('p', 'Загрузить еще', ['class' => 'btn btn-success', 'data-offset' => $offset, 'data-count' => $count]) ?>
            </div>
        <?php endif; ?>
        <br>
        <br>
        <div class="buttons-area-bottom text-center">
            <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
        </div>
    </div>
</div>
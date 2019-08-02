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

    <?php if (count($operationsByDate) !== 0) :  ?>
        <div class="col-md-12">
            <h1>Операции</h1>

            <?php  // var_dump($operationsArrayByDate); 
            ?>

            <?php foreach ($operationsByDate as $operation) : ?>
                <?= OperationByDayWidget::widget(['model' => $operation])?>
            <?php  endforeach; ?>
            <?= Html::a('Сбросить фильтры', '/operation/view'); ?>


        <?php else : ?>
            <div class="col-md-offset-2 col-md-8">
                <h1>Операции</h1>
                <h4>Операций нет</h4>
                <?php if (Yii::$app->request->queryParams) : ?>
                    <?= Html::a('Сбросить фильтры', '/operation/view'); ?>
                    <br>
                <?php endif; ?>
            <?php endif; ?>
            <?= Html::a('Добавить', ['/operation/create/'], ['class' => 'btn btn-primary']); ?>
            <br>
            <br>
            <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>

        </div>

    </div>


</div>
</div>
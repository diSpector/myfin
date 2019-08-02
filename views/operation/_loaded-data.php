<?php

use yii\helpers\Html;
use app\widgets\OperationByDayWidget\OperationByDayWidget;

?>

<?php foreach ($operationsByDate as $operation) : ?>
    <?= OperationByDayWidget::widget(['model' => $operation]) ?>
<?php endforeach; ?>
<?php if ($more) : ?>
    <div class="buttons-load-more text-center">
        <?= Html::tag('p', 'Загрузить еще', ['class' => 'btn btn-success', 'data-offset' => $offset, 'data-count' => $count]) ?>
    </div>
<?php endif; ?>
<?php

use yii\helpers\Html;
use app\widgets\OperationByDayWidget\OperationByDayWidget;

?>

<?php foreach ($operations as $date => $operationBlock) : ?>
    <?= OperationByDayWidget::widget(['title' => $date, 'model' => $operationBlock]) ?>
<?php endforeach; ?>
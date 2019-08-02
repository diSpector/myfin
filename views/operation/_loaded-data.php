<?php

use yii\helpers\Html;
use app\widgets\OperationByDayWidget\OperationByDayWidget;

?>

<?php foreach ($operationsByDate as $operation) : ?>
    <?= OperationByDayWidget::widget(['model' => $operation]) ?>
<?php endforeach; ?>
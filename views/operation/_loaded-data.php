<?php

use yii\helpers\Html;
use app\widgets\OperationByDayWidget\OperationByDayWidget;

?>

<?php foreach ($operations as $operation) : ?>
    <?= OperationByDayWidget::widget(['model' => $operation]) ?>
<?php endforeach; ?>
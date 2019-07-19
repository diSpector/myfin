<?php

use yii\helpers\Html;

$condition = $model->type === 1;
$text = $condition ? 'Расход' : 'Приход';
$color = $condition ? 'red' : 'blue';
?>

<tr>
    <?= Html::tag('td', ++$index) ?>
    <?= Html::tag('td', $model->name) ?>
    <?= Html::tag('td', $text, ['style' => 'color:' . $color]) ?>
</tr>
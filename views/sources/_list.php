<?php
use yii\helpers\Html;
?>
 
<tr>
    <?= Html::tag('td',++$index) ?> 
    <?= Html::tag('td',$model->name) ?> 
</tr>
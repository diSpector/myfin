<?php

use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <h1>Операции</h1>
        <h4>Для того, чтобы добавлять операции, нужно добавить хотя бы один источник и категорию:</h4>
        <?= Html::a('- Добавить источник', '/sources/view'); ?>
        <br>
        <?= Html::a('- Добавить категорию', '/category/view'); ?>
        <br>
        <br>
        <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
    </div>
</div>
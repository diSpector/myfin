<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h1>Авторизация</h1>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'email'); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <div class="col-lg-12">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php $form->end(); ?>
    </div>
</div>
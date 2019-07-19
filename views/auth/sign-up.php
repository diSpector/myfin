<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h1>Регистрация</h1>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'email'); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <?= $form->field($model, 'passwordRepeat')->passwordInput(); ?>
            <div class="col-lg-12">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php $form->end(); ?>
    </div>
</div>
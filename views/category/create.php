<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\widgets\DefaultItemWidget;

?>

<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h1>Создание новой категории</h1>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name', [
            'inputOptions' => [
                'id' => 'category-name',
                'class' => 'form-control',
            ],
        ]); ?>

        <p>Например,
            <?php foreach ($default_categories as $default_category) : ?>
                <?= DefaultItemWidget::widget(['text' => $default_category->name])  . ','; ?>
            <?php endforeach; ?>
        </p>

        <?= $form->field($model, 'type')->dropDownList($types); ?>

        <div class="col-lg-12">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php $form->end(); ?>

        <br>
        <br>
        <h3>Уже существующие категории:</h3>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'table',
                'class' => 'table table-striped table-bordered',
                'id' => 'categories',

            ],
            // вид каждой строки задается в файле _list.php, 
            // туда же инжектируется порядковый номер $index и весь объект $model
            'itemView' => '_list',
            'emptyText' => 'Список пуст',
            'emptyTextOptions' => [
                'tag' => 'p'
            ],
            'summary' => '',
        ]); ?>

        <?= Html::a('Назад к списку категорий', ['/category/view'], ['class' => 'badge badge-light']) ?>
        <br>
        <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>
    </div>
</div>
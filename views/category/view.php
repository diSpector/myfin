<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\OperationForm;

?>

<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <h1>Ваши категории</h1>
    <?php if ($dataProvider->getTotalCount() !== 0) : ?>
      <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $filterModel,
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],
              [
                  'label' => 'Категория',
                  'attribute' => 'name'
              ],
              [
                  'attribute' => 'type',
                  'contentOptions' => function ($data, $key, $index, $column) {
                    return ['style' => 'color:'
                        . ($data->type == 1 ? 'red' : 'blue')];
                  },
                  'filter' => ArrayHelper::map(OperationForm::find()->asArray()->all(), 'id', 'name'),
                  'value' => function ($data) {
                    return $data->type == 1 ? 'Расход' : 'Приход';
                  }
              ],
              [
                  'header' => 'Действие',
                  'class' => 'yii\grid\ActionColumn',
                  'buttons' => [
                      'delete' => function ($url, $model, $key) {
                        return Html::a('Удалить', ['/category/delete/'], [
                            'class' => 'btn btn-danger',
                            'data-confirm' => 'Вы уверены, что хотите удалить эту категорию?',
                            'data-method' => 'post',
                            'data-params' => [
                                'id' => $model->id,
                            ],
                        ]);
                      },
                      'update' => function ($url, $model, $key) {
                        $customUrl = '/category/update/' . $model->id;
                        return Html::a('Изменить', $customUrl, [
                            'title' => Yii::t('yii', 'Изменить'),
                            'data-method' => 'post',
                            'class' => 'btn btn-primary',
                        ]);
                      },
                  ],
                  'template' => '{update} {delete}',
              ],
          ]
      ]); ?>

    <?php else: ?>
      <h4>Категорий пока нет</h4>
    <?php endif; ?>

    <?= Html::a('Добавить', ['category/create/'], ['class' => 'btn btn-primary']); ?>
    <br>
    <br>

    <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>

  </div>
</div>
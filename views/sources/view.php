<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <h1>Ваши источники (карты и кошельки)</h1>
      <?php if ($dataProvider->getTotalCount() !== 0): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Источник',
                    'attribute' => 'name'
                ],
                [
                    'label' => 'Тип',
                    'attribute' => 'type',
                    'value' => function($data){
                        return $data->type === 1 ? 'Безналичный' : 'Наличный';
                    }
                ],
                [
                    'label' => 'Начальное значение',
                    'attribute' => 'total',
                ],
                [
                    'header' => 'Действие',
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Удалить', ['/sources/delete/'], [
                                'class' => 'btn btn-danger',
                                'data-confirm' => 'Вы уверены, что хотите удалить этот источник?',
                                'data-method' => 'post',
                                'data-params' => [
                                    'id' => $model->id,
                                ],
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            $customUrl = '/sources/update/' . $model->id;
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
        <h4>Источников пока нет</h4>
      <?php endif; ?>
        <?= Html::a('Добавить', ['/sources/create/'], ['class' => 'btn btn-primary']); ?>
        <br>
        <br>

        <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>    

    </div>
</div>
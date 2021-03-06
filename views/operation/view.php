<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\OperationForm;
use app\models\OperationType;

?>

<div class="row">

    <?php if (!$dataProvider->getCount() === 0) :  ?>
        <div class="col-md-12">
            <h1>Операции</h1>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $filterModel,
                // 'showOnEmpty' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Сумма',
                        'attribute' => 'sum'
                    ],
                    [
                        'label' => 'Описание',
                        'attribute' => 'name'
                    ],
                    [
                        'label' => 'Категория',
                        'attribute' => 'category_id',
                        // 'attribute' => 'category.name'
                        'value' => function ($model) {
                            return $model->category->name;
                        }
                    ],
                    [
                        'label' => 'Источник',
                        'attribute' => 'source_id',
                        // 'attribute' => 'source.name'
                        'value' => function ($model) {
                            return $model->source->name;
                        }

                    ],
                    [
                        'attribute' => 'operation_type',
                        'filter' => ArrayHelper::map(OperationType::find()->asArray()->all(), 'id', 'name'),
                        'value' => function ($data) {
                            return $data->source->type == 1 ? 'Безналичный' : 'Наличный';
                        }
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
                        // 'buttons' => [
                        //     'delete' => function ($url, $model, $key) {
                        //         return Html::a('Удалить', ['/operation/delete/'], [
                        //             'class' => 'btn btn-danger',
                        //             'data-confirm' => 'Вы уверены, что хотите удалить эту категорию?',
                        //             'data-method' => 'post',
                        //             'data-params' => [
                        //                 'id' => $model->id,
                        //             ],
                        //         ]);
                        //     },
                        //     'update' => function ($url, $model, $key) {
                        //         $customUrl = '/operation/update/' . $model->id;
                        //         return Html::a('Изменить', $customUrl, [
                        //             'title' => Yii::t('yii', 'Изменить'),
                        //             'data-method' => 'post',
                        //             'class' => 'btn btn-primary',
                        //         ]);
                        //     },
                        // ],
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['/operation/delete/'], [
                                    // 'class' => 'btn btn-danger',
                                    'data-confirm' => 'Вы уверены, что хотите удалить эту категорию?',
                                    'data-method' => 'post',
                                    'data-params' => [
                                        'id' => $model->id,
                                    ],
                                ]);
                            },
                        ],
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        <?php else : ?>
            <div class="col-md-offset-2 col-md-8">
                <h1>Операции</h1>
                <h4>Операций нет</h4>
            <?php endif; ?>
            <?= Html::a('Добавить', ['/operation/create/'], ['class' => 'btn btn-primary']); ?>
            <br>
            <br>
            <?= Html::a('На Главную', ['/site/index'], ['class' => 'badge badge-light']) ?>

        </div>

    </div>


</div>
</div>
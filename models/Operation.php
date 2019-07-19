<?php

namespace app\models;

use app\models\base\OperationBase;

class Operation extends OperationBase
{

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['date_picked', 'date', 'format' => 'php:Y-m-d', 'message' => 'Неверный формат даты. "ГГГГ-ММ-ДД"'],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'name' => 'Описание операции',
                'type' => 'Тип операции',
                'sum' => 'Сумма',
                'source_id' => 'Источник',
                'category_id' => 'Категория',
                'operation_type' => 'Вид оплаты',
                'date_picked' => 'Дата операции',
            ]
        );
    }
    // public function rules()
    // {
    //     return array_merge(
    //         [
    //             [['name'], 'trim'],
    //             // проверка уникальности категории расходов/приходов для КАЖДОГО пользователя
    //             ['name', 'unique', 'targetAttribute' => ['name', 'user_id'], 'message' => 'Для этого пользователя уже есть такая категория'],
    //         ],
    //         parent::rules()
    //     );
    // }

}

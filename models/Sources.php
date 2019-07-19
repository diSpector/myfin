<?php

namespace app\models;

use app\models\base\SourcesBase;
use app\models\Users;
use app\models\OperationType;

class Sources extends SourcesBase
{
    public function rules()
    {
        return array_merge(
            [
                [['name'], 'trim'],
                // проверка уникальности источника платежей для КАЖДОГО пользователя
                ['name', 'unique', 'targetAttribute' => ['name', 'user_id'], 'message' => 'Для этого пользователя уже есть такой источник'],
                ['total', 'number', 'message' => 'Введите число (рубли и копейки должны быть разделены точкой)'],
            ],
            parent::rules()
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::rules(),
            [
                'name' => 'Название источника платежей',
                'type' => 'Тип источника',
                'total' => 'Начальная сумма',
            ]
        );
    }
}

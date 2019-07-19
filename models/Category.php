<?php

namespace app\models;

use app\models\base\CategoryBase;
use app\models\OperationForm;
use app\models\Users;

class Category extends CategoryBase
{
    public function rules()
    {
        return array_merge(
            [
                [['name'], 'trim'],
                // проверка уникальности категории расходов/приходов для КАЖДОГО пользователя
                ['name', 'unique', 'targetAttribute' => ['name', 'user_id'], 'message' => 'Для этого пользователя уже есть такая категория'],
            ],
            parent::rules()
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::rules(),
            [
            'name' => 'Название категории',
            'type' => 'Тип'
            ]
        );
    }
}

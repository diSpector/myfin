<?php

namespace app\models;

use app\models\base\OperationBase;

class Operation extends OperationBase
{

    const SCENARIO_OPERATION = 'operation'; // обычная операция - расход/приход
    const SCENARIO_TRANSFER = 'transfer'; // операция для перекидывания денег между счетами

    public $source_id2; // счет для сценария перекидывания денег между счетами

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['date_picked', 'date', 'format' => 'php:Y-m-d', 'message' => 'Неверный формат даты. "ГГГГ-ММ-ДД"'],
                ['source_id2', 'required', 'on' => self::SCENARIO_TRANSFER, 'message' => 'Выберите счет для пополнения'],
                ['source_id2', 'compare', 'compareAttribute' => 'source_id', 'operator' => '!=', 'on' => self::SCENARIO_TRANSFER, 'message' => 'Источники должны быть разными'],
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
                'source_id' => ($this->scenario === 'transfer') ? 'Источник списания' : 'Источник',
                'category_id' => 'Категория',
                'operation_type' => 'Вид оплаты',
                'date_picked' => 'Дата операции',
                'source_id2' => 'Источник для зачисления',
            ]
        );
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_OPERATION] = ['user_id', 'category_id', 'source_id', 'sum', 'type', 'date_picked', 'name'];
        $scenarios[self::SCENARIO_TRANSFER] = ['user_id', 'source_id', 'source_id2', 'sum', 'type', 'date_picked', 'name'];
        return $scenarios;
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

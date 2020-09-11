<?php

namespace app\models;

use yii\base\Model;

class DateRangeForm extends Model
{

    const SCENARIO_OPERATION = 'operation';
    const SCENARIO_DASHBOARD = 'dashboard';

    public $dateRange;
    public $period;

    public function rules()
    {
        return array_merge([
            [['dateRange', 'period'], 'required', 'message' => 'Не указано значение {attribute}', 'on' => self::SCENARIO_DASHBOARD],
            [['dateRange'], 'required', 'message' => 'Не указано значение {attribute}', 'on' => self::SCENARIO_OPERATION],
            ['period', 'in', 'range' => [0, 1], 'message' => 'Неверное значение периода', 'on' => self::SCENARIO_DASHBOARD],
            ['dateRange', 'match', 'pattern' => '/^20\d{2}-\d{2}-\d{2}\s-\s20\d{2}-\d{2}-\d{2}$/i', 'message' => 'Неверно выбран период']
        ], parent::rules());
    }


    public function attributeLabels()
    {
        return array_merge(
            [
                'dateRange' => 'Выберите период',
                'period' => 'Способ',
            ],
            parent::attributeLabels()
        );
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_OPERATION] = ['dateRange'];
        $scenarios[self::SCENARIO_DASHBOARD] = ['dateRange', 'period'];
        return $scenarios;
    }
}

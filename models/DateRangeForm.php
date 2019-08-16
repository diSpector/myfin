<?php

namespace app\models;

use yii\base\Model;

class DateRangeForm extends Model
{

    public $dateRange;
    public $period;

    public function rules()
    {
        return array_merge([
            [['dateRange', 'period'], 'required', 'message' => 'Не указано значение {attribute}'],
            ['period', 'in', 'range' => [0, 1], 'message' => 'Неверное значение периода'],
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
}

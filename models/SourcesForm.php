<?php

namespace app\models;

use yii\base\Model;

class SourcesForm extends Model
{

    public $name;
    public $type;
    public $operation;


    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Поле {attribute} обязательно для заполнения'],
            ['type', 'required'],
            ['type', 'in', 'range' => [1, 2], 'allowArray' => true],
            ['operation', 'required'],
            // ['operation', 'in', 'range' => ['Приход', 'Расход'], 'allowArray' => true],
            ['operation', 'in', 'range' => [0, 1], 'allowArray' => true],

        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Тип источника',
            'name' => 'Название источника',
            'operation' => 'Тип операции',

        ];
    }
}

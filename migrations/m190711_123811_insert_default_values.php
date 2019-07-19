<?php

use yii\db\Migration;

/**
 * Class m190711_123811_insert_default_values
 */
class m190711_123811_insert_default_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // добавить стандартные данные (категории расходов/доходов, типы операций) в таблицы

        $this->batchInsert('default_cost_category', 
            ['name'], 
            [
                ['Продукты'],
                ['Транспорт'],
                ['Здоровье'],
                ['Вещи'],
                ['Кафе'],
            ]
        );

        $this->batchInsert('default_income_category', 
            ['name'], 
            [
                ['Зарплата'],
                ['Возврат долга'],
                ['Кэшбек'],
                ['Проценты с вклада'],
                ['Продажа'],
            ]
        );

        $this->batchInsert('operation_type', 
            ['name'], 
            [
                ['Безналичный'],
                ['Наличный'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('default_cost_category');
        $this->truncateTable('default_income_category');
        $this->truncateTable('operation_type');
    }

}

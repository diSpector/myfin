<?php

use yii\db\Migration;

/**
 * Class m190717_072415_add_operation_form_table_and_costs_name
 */
class m190717_072415_add_operation_form_table_and_costs_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         *
         * Таблица operation_form - тип операции - приход или расход
         *
         */
        $this->createTable('operation_form', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
        ]);

        // добавить исходные значения в таблицу operation_form
        $this->batchInsert(
            'operation_form',
            ['name'],
            [
                ['Расход'],
                ['Приход'],
            ]
        );

        // добавить колонки с названиями операций в таблицы расходов и доходов
        $this->addColumn('costs', 'name', $this->string(45)->notNull());
        $this->addColumn('incomes', 'name', $this->string(45)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('operation_form');
        $this->dropColumn('costs', 'name');
        $this->dropColumn('incomes', 'name');
    }
}

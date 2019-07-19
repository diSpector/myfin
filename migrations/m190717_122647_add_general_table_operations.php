<?php

use yii\db\Migration;

/**
 * Class m190717_122647_add_general_table_operations
 */
class m190717_122647_add_general_table_operations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // таблица operation для хранения ВСЕХ операций (расходы + приходы)
        $this->createTable('operations', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(11)->notNull(),
            'category_id'     => $this->integer(11)->notNull(),
            'source_id'       => $this->integer(11)->notNull(),
            'sum'             => $this->decimal(10, 2)->notNull(),
            'name'            => $this->string(200),
            'type'            => $this->integer()->notNull(),
            'date_created'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'date_picked'     => $this->dateTime()->notNull(),
        ]);

        // таблица category для хранения ВСЕХ категорий (расходов + приходов)
        $this->createTable('category', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(11)->notNull(),
            'name'            => $this->string(200)->notNull(),
            'type'            => $this->integer()->notNull(),
        ]);

        // таблица default_category для хранения ВСЕХ стандартных категорий (расходов + приходов)
        $this->createTable('default_category', [
            'id'              => $this->primaryKey(),
            'name'            => $this->string(30),
            'type'            => $this->integer()->notNull(),
        ]);

        // вставка начальных значений стандартных категорий (расходов + приходов)
        $this->batchInsert(
            'default_category',
            ['name', 'type'],
            [
                ['Продукты', 1],
                ['Транспорт', 1],
                ['Здоровье', 1],
                ['Вещи', 1],
                ['Кафе', 1],
                ['Зарплата', 2],
                ['Возврат долга', 2],
                ['Кэшбек', 2],
                ['Проценты с вклада', 2],
                ['Продажа', 2],
            ]
        );



        // внешние ключи

        $this->addForeignKey(
            'fk-operations-users',
            'operations',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-operations-category',
            'operations',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-operations-sources',
            'operations',
            'source_id',
            'sources',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-operations-operation_form',
            'operations',
            'type',
            'operation_form',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-category-users',
            'category',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-category-operation_form',
            'category',
            'type',
            'operation_form',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-default_category-operation_form',
            'default_category',
            'type',
            'operation_form',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-operations-users',
            'operations'
        );

        $this->dropForeignKey(
            'fk-operations-category',
            'operations'
        );

        $this->dropForeignKey(
            'fk-operations-sources',
            'operations'
        );

        $this->dropForeignKey(
            'fk-operations-operation_form',
            'operations'
        );

        $this->dropForeignKey(
            'fk-category-users',
            'category'
        );

        $this->dropForeignKey(
            'fk-category-operation_form',
            'category'
        );

        $this->dropForeignKey(
            'fk-default_category-operation_form',
            'default_category'
        );

        $this->dropTable('operations');
        $this->dropTable('category');
        $this->dropTable('default_category');
    }
}

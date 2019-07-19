<?php

use yii\db\Migration;

/**
 * Class m190711_102606_init_create_tables
 */
class m190711_102606_init_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         *
         * Таблица users - пользователи
         *
         */
        $this->createTable('users', [
            'id'              => $this->primaryKey(),
            'email'           => $this->string(45)->notNull()->unique(),
            'name'            => $this->string(45)->notNull(),
            'password_hash'   => $this->string(255), 
            'enabled'         => $this->boolean()->defaultValue(false),
            'date_created'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'last_login'      => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // $this->createIndex('idx_u-customers-hash', 'customers', 'hash', true);

        /**
         *
         * Таблица cost_category - категории расходов
         *
         */
        $this->createTable('cost_category', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
            'user_id'    => $this->integer(11)->notNull(),
        ]);


        /**
         *
         * Таблица income_category - категории доходов
         *
         */
        $this->createTable('income_category', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
            'user_id'    => $this->integer(11)->notNull(),
        ]);

        /**
         *
         * Таблица default_cost_category - стандартные категории расходов
         *
         */
        $this->createTable('default_cost_category', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
        ]);

        /**
         *
         * Таблица default_income_category - стандартные категории доходов
         *
         */
        $this->createTable('default_income_category', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
        ]);

        /**
         *
         * Таблица operation_type - тип расходов и расходов - нал или безнал
         *
         */
        $this->createTable('operation_type', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
        ]);

        // /**
        //  *
        //  * Таблица income_type - тип приходов - нал/безнал
        //  *
        //  */
        // $this->createTable('income_type', [
        //     'id'         => $this->boolean(),
        //     'name'       => $this->string(45)->notNull(),
        // ]);

        /**
         *
         * Таблица cost_sources - откуда пользователи тратят деньги - конкретные карты/кошельки
         *
         */
        $this->createTable('cost_sources', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
            'type'       => $this->integer()->notNull(),
            'user_id'    => $this->integer(11)->notNull(),
        ]);

        /**
         *
         * Таблица income_sources - куда пользователи получают деньги - конкретные карты/кошельки
         *
         */
        $this->createTable('income_sources', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
            'type'       => $this->integer()->notNull(),
            'user_id'    => $this->integer(11)->notNull(),
        ]);

        /**
         *
         * Таблица init_state - начальное состояние кошельков
         *
         */
        $this->createTable('init_state', [
            'id'              => $this->primaryKey(),
            'source_id'       => $this->integer(11)->notNull(),
            'total'           => $this->decimal(2)->defaultValue(0),
            'date_created'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'date_updated'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        /**
         *
         * Таблица costs - все расходы всех пользователей
         *
         */
        $this->createTable('costs', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(11)->notNull(),
            'category_id'     => $this->integer(11)->notNull(),
            'source_id'       => $this->integer(11)->notNull(),
            'sum'             => $this->decimal(2)->notNull(),
            'date_created'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            ]);

        /**
         *
         * Таблица incomes - все доходы всех пользователей
         *
         */
        $this->createTable('incomes', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(11)->notNull(),
            'category_id'     => $this->integer(11)->notNull(),
            'source_id'       => $this->integer(11)->notNull(),
            'sum'             => $this->decimal(2)->notNull(),        
            'date_created'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            ]);

        // внешние ключи

        $this->addForeignKey(
            'fk-cost_category-users',
            'cost_category',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-income_category-users',
            'income_category',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-cost_sources-users',
            'cost_sources',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-cost_sources-operation_type',
            'cost_sources',
            'type',
            'operation_type',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-income_sources-users',
            'income_sources',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-income_sources-operation_type',
            'income_sources',
            'type',
            'operation_type',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-init_state-cost_sources-type',
            'init_state',
            'source_id',
            'cost_sources',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-costs-users',
            'costs',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-costs-cost_category',
            'costs',
            'category_id',
            'cost_category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-costs-costs_sources',
            'costs',
            'source_id',
            'cost_sources',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-incomes-users',
            'incomes',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-incomes-cost_category',
            'incomes',
            'category_id',
            'income_category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-incomes-costs_sources',
            'incomes',
            'source_id',
            'income_sources',
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
            'fk-cost_category-users',
            'cost_category'
        );

        $this->dropForeignKey(
            'fk-income_category-users',
            'income_category'
        );

        $this->dropForeignKey(
            'fk-cost_sources-users',
            'cost_sources'
        );

        $this->dropForeignKey(
            'fk-cost_sources-operation_type',
            'cost_sources'
        );

        $this->dropForeignKey(
            'fk-income_sources-users',
            'income_sources'
        );

        $this->dropForeignKey(
            'fk-income_sources-operation_type',
            'income_sources'
        );

        $this->dropForeignKey(
            'fk-init_state-cost_sources-type',
            'init_state'
        );

        $this->dropForeignKey(
            'fk-costs-users',
            'costs'
        );

        $this->dropForeignKey(
            'fk-costs-cost_category',
            'costs'
        );

        $this->dropForeignKey(
            'fk-costs-costs_sources',
            'costs'
        );

        $this->dropForeignKey(
            'fk-incomes-users',
            'incomes'
        );

        $this->dropForeignKey(
            'fk-incomes-cost_category',
            'incomes'
        );

        $this->dropForeignKey(
            'fk-incomes-costs_sources',
            'incomes'
        );


        $this->dropTable('users');
        $this->dropTable('cost_category');
        $this->dropTable('income_category');
        $this->dropTable('default_cost_category');
        $this->dropTable('default_income_category');
        $this->dropTable('operation_type');
        $this->dropTable('cost_sources');
        $this->dropTable('income_sources');
        $this->dropTable('init_state');
        $this->dropTable('costs');
        $this->dropTable('incomes');
    }
}

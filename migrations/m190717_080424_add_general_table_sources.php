<?php

use yii\db\Migration;

/**
 * Class m190717_080424_add_general_table_sources
 */
class m190717_080424_add_general_table_sources extends Migration
{
    /**
     *
     * Таблица sources - места для хранения всех источников (карты, кошельки),
     * с которых и на которые будут производиться операции,
     * и начальных сумм на этих картах
     *
     */
    public function safeUp()
    {
        $this->createTable('sources', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(45)->notNull(),
            'type'       => $this->integer()->notNull(),
            'user_id'    => $this->integer(11)->notNull(),
            'total'           => $this->decimal(10,2)->notNull(),
            'date_created'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'date_updated'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // внешние ключи

        $this->addForeignKey(
            'fk-sources-users',
            'sources',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sources-operation_type',
            'sources',
            'type',
            'operation_type',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-init_state-sources-type',
            'init_state',
            'source_id',
            'sources',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-costs-sources',
            'costs',
            'source_id',
            'sources',
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
            'fk-sources-users',
            'sources'
        );

        $this->dropForeignKey(
            'fk-sources-operation_type',
            'sources'
        );

        $this->dropForeignKey(
            'fk-init_state-sources-type',
            'init_state'
        );

        $this->dropForeignKey(
            'fk-costs-sources',
            'costs'
        );

        $this->dropTable('sources');
    }
}

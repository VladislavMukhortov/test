<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offers}}`.
 */
class m190516_101137_create_offers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%offers}}', [
            'id' => $this->primaryKey()->unsigned(),
            'lot_id' => $this->integer()->unsigned()->notNull(),                    // ID объявления
            'lot_owner_id' => $this->integer()->unsigned()->notNull(),              // ID компании которая подала объявление покупки/продажи
            'counterparty_id' => $this->integer()->unsigned()->notNull(),           // ID компании(второй стороны) которая проявила интерес к объявлению
            'user_owner_id' => $this->integer()->unsigned()->notNull(),             // ID пользователя который подал заявлеине
            'user_counterparty_id' => $this->integer()->unsigned()->notNull(),      // ID пользователя который проявил интерес к объявлению

            'require_price_1' => $this->decimal(10,2)->unsigned()->defaultValue(null),  // первая цена оффера от второй стороны
            'require_price_2' => $this->decimal(10,2)->unsigned()->defaultValue(null),  // вторая цена оффера от второй стороны
            'require_price_3' => $this->decimal(10,2)->unsigned()->defaultValue(null),  // третья цена оффера от второй стороны
            'lot_price_1' => $this->decimal(10,2)->unsigned()->defaultValue(null),      // ответ на первую цену от второй стороны
            'lot_price_2' => $this->decimal(10,2)->unsigned()->defaultValue(null),      // ответ на вторую цену от второй стороны

            'auction_time_s' => $this->smallInteger()->defaultValue(null),          // время в секундах на которое дается "твердо" (дает владелец объявления)

            'link' => $this->string(200)->notNull()->unique(),                      // ссылка

            'status' => $this->tinyInteger()->unsigned()->defaultValue(0),          // статус офера

            'created_at' => 'timestamp DEFAULT NOW()',                              // дата создания
            'updated_at' => 'timestamp ON UPDATE NOW()',                            // дата изменения
            'ended_at' => $this->timestamp()->defaultValue(null),                   // время окончания "твердо" между пользователями
        ], $tableOptions);

        $table_name = $this->db->getSchema()->getRawTableName('{{%offers}}');

        // add foreign key for table `company`
        $this->addForeignKey(
            "{$table_name}_lot_owner_id_fk",
            "{$table_name}",
            'lot_owner_id',
            '{{%company}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            "{$table_name}_counterparty_id_fk",
            "{$table_name}",
            'counterparty_id',
            '{{%company}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        // add foreign key for table `lots`
        $this->addForeignKey(
            "{$table_name}_lot_id_fk",
            "{$table_name}",
            'lot_id',
            '{{%lots}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->addForeignKey(
            "{$table_name}_user_owner_id_fk",
            "{$table_name}",
            'user_owner_id',
            '{{%users}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->addForeignKey(
            "{$table_name}_user_counterparty_id_fk",
            "{$table_name}",
            'user_counterparty_id',
            '{{%users}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%offers}}');
    }
}

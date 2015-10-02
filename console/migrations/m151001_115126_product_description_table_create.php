<?php

use yii\db\Schema;
use yii\db\Migration;

class m151001_115126_product_description_table_create extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        }

        $this->createTable(
            '{{%product_desc}}',
            [
                'product_id' => $this->integer()->notNull() . ' COMMENT "Product ID"',
                'description' => $this->text()->notNull() . ' COMMENT "Product description"',
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'product_desc__product_id__fk',
            '{{%product_desc}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        if('mysql' === $this->db->driverName) {
            $sql = 'ALTER TABLE ' . $this->db->schema->quoteTableName('{{%product_desc}}') . '
                    ADD FULLTEXT `product_desc__description__ftidx` (`description`)';

            $this->db->createCommand($sql)->execute();
        }
    }

    public function safeDown()
    {
        if('mysql' === $this->db->driverName) {
           $this->dropIndex('product_desc__description__ftidx', '{{%product_desc}}');
        }

        $this->dropForeignKey('product_desc__product_id__fk', '{{%product_desc}}');

        $this->dropTable('{{%product_desc}}');
    }
}

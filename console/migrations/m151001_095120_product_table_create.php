<?php

use yii\db\Schema;
use yii\db\Migration;

class m151001_095120_product_table_create extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%product}}',
            [
                'id' => $this->primaryKey() . ' COMMENT "Product ID"',
                'shop_id' => $this->integer()->notNull() . ' COMMENT "Shop ID"',
                'catalog_id' => $this->integer()->notNull() . ' COMMENT "Catalog ID"',
                'title' => $this->string(80)->notNull() . ' COMMENT "Product short title"',
                'hint' => $this->string(255) . ' COMMENT "Product title hint"',
                'image_id' => $this->integer()->notNull() . ' COMMENT "Product main image"',
            ],
            $tableOptions
        );

        $this->createIndex(
            'product__shop_id__idx',
            '{{%product}}',
            'shop_id'
        );

        $this->createIndex(
            'product__shop_id__catalog_id__idx',
            '{{%product}}',
            ['shop_id', 'catalog_id']
        );

        $this->createIndex(
            'product__title__idx',
            '{{%product}}',
            'title'
        );
    }

    public function safeDown()
    {
        $this->dropIndex('product__title__idx', '{{%product}}');
        $this->dropIndex('product__shop_id__catalog_id__idx', '{{%product}}');
        $this->dropIndex('product__shop_id__idx', '{{%product}}');

        $this->dropTable('{{%product}}');
    }
}

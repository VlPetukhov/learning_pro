<?php

use \common\components\FileStorage\LocalFileStorage;
use yii\db\Migration;

class m151014_103637_file_storage_add_forieng_key extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk_storagstorage_id',
            LocalFileStorage::FILES_TABLE_NAME,
            'storage_id',
            LocalFileStorage::STORAGES_TABLE_NAME,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_storagstorage_id', LocalFileStorage::FILES_TABLE_NAME);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

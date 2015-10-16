<?php

use common\components\FileStorage\LocalFileStorage;
use yii\db\Migration;

class m151014_103129_file_storage_storages_table_creation extends Migration
{
    public function up()
    {
        $this->createTable(
            LocalFileStorage::STORAGES_TABLE_NAME,
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'public' => $this->boolean()->notNull()->defaultValue(true),
            ]
        );
    }

    public function down()
    {
        $this->dropTable(LocalFileStorage::STORAGES_TABLE_NAME);
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

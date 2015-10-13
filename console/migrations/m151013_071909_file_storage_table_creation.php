<?php

use common\components\FileStorage\LocalFileStorage;
use yii\db\Migration;

class m151013_071909_file_storage_table_creation extends Migration
{
    public function up()
    {
        $this->createTable(
            LocalFileStorage::STORAGE_TABLE_NAME,
            [
                'id' => $this->primaryKey(),
                'storage' => $this->string(80)->notNull(),
                'sub_folder' => $this->integer()->notNull(),
                'original_name' => $this->string()->notNull(),
                'local_name' => $this->string()->notNull(),
                'uploaded' => $this->timestamp()->notNull() . ' DEFAULT NOW()',
                'updated' =>  $this->integer()->notNull()->defaultValue(-1),
                'expired' => $this->integer()->notNull()->defaultValue(-1),
                'deleted' => $this->boolean()->notNull()->defaultValue(false),
                'delete_time' => $this->integer()->notNull()->defaultValue(-1),
            ]
        );
    }

    public function down()
    {
        $this->dropTable(LocalFileStorage::STORAGE_TABLE_NAME);
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

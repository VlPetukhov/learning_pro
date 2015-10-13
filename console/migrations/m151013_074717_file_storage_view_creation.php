<?php

use \common\components\FileStorage\LocalFileStorage;
use yii\db\Migration;

class m151013_074717_file_storage_view_creation extends Migration
{
    public function up()
    {
        $viewTableName = LocalFileStorage::STORAGE_TABLE_NAME . '_counter';
        $sql = "CREATE OR REPLACE VIEW {$viewTableName}
                AS
                SELECT storage, sub_folder, COUNT(id) AS files_cnt, CONCAT(storage, sub_folder) AS sub_folder_name
                FROM local_storage_files
                GROUP BY sub_folder_name";

        Yii::$app->db->createCommand($sql)->execute();
    }

    public function down()
    {
        $viewTableName = LocalFileStorage::STORAGE_TABLE_NAME . '_counter';
        $sql = "DROP VIEW IF EXISTS {$viewTableName}";

        Yii::$app->db->createCommand($sql)->execute();
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

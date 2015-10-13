<?php
/**
 * File storage on server local disk
 *
 * @class LocalFileStorage
 * @namespace common\components\FileStorage
 */

namespace common\components\FileStorage;

use Yii;

class LocalFileStorage extends FileStorageBase
{
    const STORAGE_TABLE_NAME = 'local_storage_files';

    /**
     * @var string directory file storages
     */
    protected $_directoryName;

    /**
     * @var \yii\db\Connection
     */
    protected $_dbConnection;

    /**
     * @param array $storageName
     * @param null | \yii\db\Connection $dbConnection
     * @throws \ErrorException
     */
    public function __construct($storageName, $directoryName = null, $dbConnection = null)
    {
        if( ! $this->storageExists($storageName)) {
            $this->createNewStorage($storageName);
        }

        $this->_storageName = $storageName;

        if(isset($dbConnection) && $dbConnection instanceof \yii\db\Connection) {

            $this->_dbConnection = $dbConnection;
        } else {
            $this->_dbConnection = Yii::$app->db;
        }

        if($directoryName && is_string($directoryName)) {
            $this->_directoryName = $directoryName;
        } else {
            $this->_directoryName = Yii::getAlias('@common') . DIRECTORY_SEPARATOR . 'fileStorage' . DIRECTORY_SEPARATOR;
        }

    }


    /**
     * Getters and Setters
     */

    /**
     * @param string $directoryName
     * @return null|string
     */
    public function setDirectoryName($directoryName)
    {
        if(is_string($directoryName))
        {
            $this->$_directoryName = $directoryName;

            return $this->$_directoryName;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getDirectoryName()
    {
        return $this->$_directoryName;
    }

    /**
     * Abstract class methods realization
     */

    /**
     * @inheritdoc
     */
    protected function storageExists($storageName)
    {
        $tableName = self::STORAGE_TABLE_NAME;
        //checking of db record existence
        $sql = "SELECT id FROM {$tableName} WHERE storage = :storage AND sub_folder = 0 LIMIT 1";

        $queryResult = $this->_dbConnection->createCommand($sql, [':storage' => $storageName])->queryScalar();

        $result = ( false !== $queryResult ) && $this->checkStorageDirectory($storageName);

        return $result;
    }

    /**
     * @param string $storageName
     * @return bool
     */
    protected function checkStorageDirectory($storageName)
    {
        // in existed storage should exist at least subFolder with index 0
        $dirName = $this->_directoryName. $storageName . DIRECTORY_SEPARATOR . $this->cipherSubDirectory($storageName, 0);

        return file_exists($dirName);
    }

    /**
     * Generates subFolder name
     *
     * @param  string $storageName
     * @param string|integer $id
     * @return string
     */
    public function cipherSubDirectory($storageName, $id)
    {
        return md5($storageName . $id);
    }

    /**
     * @inheritdoc
     */
    protected function createNewStorage($storageName)
    {

    }

    /**
     * @inheritdoc
     */
    function getFilePath($fileId)
    {

    }

    /**
     * @inheritdoc
     */
    function addFile( $filePath)
    {

    }

    /**
     * @inheritdoc
     */
    function uploadFile( \yii\web\UploadedFile $file)
    {

    }

    /**
     * @inheritdoc
     */
    function setFileTemporal($fileId, $deleteTime)
    {

    }

    /**
     * @inheritdoc
     */
    function setFilePermanent($fileId)
    {

    }
}
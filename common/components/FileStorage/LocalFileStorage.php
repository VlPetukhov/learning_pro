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
    const STORAGES_TABLE_NAME = 'local_storage_storages';

    const FILES_TABLE_NAME = 'local_storage_files';

    const PROTECTED_STORAGES_DIR_NAME = 'file_storages';

    /**
     * @var string public storages directory name
     */
    protected $_publicStoragesDirectory;

    /**
     * @var string protected storages directory name
     */
    protected $_protectedStoragesDirectory;

    /**
     * @var string storage directory name
     */
    protected $_storageName;

    /**
     * @var integer storageId
     */
    protected $_storageId;

    /**
     * @var \yii\db\Connection
     */
    protected $_dbConnection;

    /**
     * @param array $storageName
     * @param array $options
     * @throws \ErrorException
     */
    public function __construct($storageName, array $options = [])
    {
        $this->_storageName = $storageName;

        if(isset($option['dbConnection']) && $option['dbConnection'] instanceof \yii\db\Connection) {

            $this->_dbConnection = $option['dbConnection'];
        } else {
            $this->_dbConnection = Yii::$app->db;
        }

        if($option['publicStoragesDirectory'] && is_string($option['publicStoragesDirectory'])) {
            $this->_publicStoragesDirectory = $option['publicStoragesDirectory'];
        } else {
            $this->_publicStoragesDirectory = Yii::getAlias('@web') . DIRECTORY_SEPARATOR;
        }

        if($option['protectedStoragesDirectory'] && is_string($option['protectedStoragesDirectory'])) {
            $this->_protectedStoragesDirectory = $option['protectedStoragesDirectory'];
        } else {
            $this->_protectedStoragesDirectory = Yii::getAlias('@common') .
                                                 DIRECTORY_SEPARATOR .
                                                 self::PROTECTED_STORAGES_DIR_NAME .
                                                 DIRECTORY_SEPARATOR;
        }
        if( ! $this->storageExists($storageName)) {
            $this->createNewStorage($storageName);
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
        $tableName = self::STORAGES_TABLE_NAME;
        //checking of db record existence - there should be at least one record with given parameters
        $sql = "SELECT id, public FROM {$tableName} WHERE storage = :storage LIMIT 1";

        $queryResult = $this->_dbConnection->createCommand($sql, [':storage' => $storageName])->queryOne();

        if( $results = ( false !== $queryResult)) {
            $this->_storageId = (int)$queryResult['id'];
            $this->_public = (bool)$queryResult['public'];

            $this->checkStorageDirectory($storageName);

        }

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
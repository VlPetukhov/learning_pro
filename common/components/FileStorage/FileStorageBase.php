<?php
/**
 * @class FileStorageBase
 * @namespace common\components\FileStorage
 */

namespace common\components\FileStorage;


use yii\base\Object;

abstract class FileStorageBase extends Object{

    /**
     * @var string - contains storage name
     */
    protected $_storageName;

    /**
     * this function should check for storage existence
     *
     * @param string $storageName
     * @return boolean
     */
    abstract protected function storageExists($storageName);

    /**
     * this function should create new storage in DB and in file
     *
     * @param string $storageName
     * @return boolean
     */
    abstract protected function createNewStorage($storageName);

    /**
     * @param string $fileId
     * @return string
     */
    abstract function getFilePath($fileId);

    /**
     * @param string $filePath path to file
     * @return boolean
     */
    abstract function addFile( $filePath);

    /**
     * @param \yii\web\UploadedFile $file
     * @return boolean
     */
    abstract function uploadFile( \yii\web\UploadedFile $file);

    /**
     * @param integer $fileId
     * @param integer $deleteTime It's a timestamp.
     * @return boolean
     */
    abstract function setFileTemporal($fileId, $deleteTime);

    /**
     * @param integer $fileId
     * @return boolean
     */
    abstract function setFilePermanent($fileId);
}

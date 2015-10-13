<?php
/**
 * @class PublicLocalFileStorage
 * @namespace common\components\FileStorage
 */

namespace common\components\FileStorage;

use Yii;

class PublicLocalFileStorage extends \LocalFileStorage
{
    public function __construct($storageName, $directoryName = null, $dbConnection = null)
    {
        parent::__construct($storageName, null, $dbConnection);

        $this->_directoryName = ($directoryName && is_string($directoryName)) ? $directoryName : Yii::getAlias('@web') . DIRECTORY_SEPARATOR;
    }


    /**
     * @param integer $fileId
     * @param bool $relativeUrl
     *
     * @return string
     */
    function getFileUrl($fileId, $relativeUrl = true)
    {

    }
}
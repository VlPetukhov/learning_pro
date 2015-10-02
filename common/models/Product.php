<?php
/**
 * Base class for products
 *
 * @class Product
 * @namespace common\models
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $catalog_id
 * @property string $title
 * @property string $hint
 * @property integer $image_id
 * @property string $description
 */

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\db\QueryBuilder;

class Product extends ActiveRecord
{
    /**
     * @var string|null $_description
     */
    public $_description = '';

    /**
     * @return string
     */
    public static function tableName ()
    {
        return '{{%product}}';
    }

    /**
     * Model's attribute labels
     *
     * @return array
     */
    public function attributeLabels ()
    {
        return [
            'id'          => 'ID',
            'shop_id'     => Yii::t('product', 'SHOP_ID_PROPERTY_NAME'),
            'catalog_id'  => Yii::t('product', 'CATALOG_ID_PROPERTY_NAME'),
            'title'       => Yii::t('product', 'TITLE_PROPERTY_NAME'),
            'hint'        => Yii::t('product', 'HINT_PROPERTY_NAME'),
            'image_id'    => Yii::t('product', 'IMAGE_ID_PROPERTY_NAME'),
            'description' => Yii::t('product', 'DESCRIPTION_PROPERTY_NAME'),
        ];
    }

    /**
     * Model's property rules
     *
     * @return array
     */
    public function rules ()
    {
        return [
            [['shop_id', 'catalog_id', 'title', 'image_id'], 'required', 'on' => ['create']],

            [['shop_id', 'catalog_id', 'image_id'], 'integer', 'on' => ['create', 'update', 'search']],

            [['title'], 'string', 'max' => 80, 'on' => ['create', 'update', 'search']],

            [['hint'], 'string', 'max' => 255, 'on' => ['create', 'update', 'search']],

            ['_description' , 'safe'],
        ];
    }

    /**
     * Description getter
     *
     * @return string
     */
    public function getDescription()
    {
        if(is_null($this->_description)) {

            $result = ( new Query())
                ->select('description')
                ->from('{{%product_desc}}')
                ->where(['product_id' => $this->id])
                ->scalar();

            $this->_description = ($result) ? $result : '';
        }

        return $this->_description;
    }

    /**
     * @param string $value
     */
    public function setDescription($value) {

        $this->_description = $value;
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {

            //@todo Make saving for description!!!

            return true;
        }

        return false;
    }

    /**
     * Model search
     *
     * @param $data
     * @return ActiveDataProvider
     */
    public function search($data)
    {
        /** @var \yii\db\ActiveQueryInterface $query */
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //try to fill model with given data and validate it. If something wrong function returns 'empty' dataProvider
        if (!($this->load($data) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['shop_id' => $this->shop_id]);
        $query->andFilterWhere(['catalog_id' => $this->catalog_id]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
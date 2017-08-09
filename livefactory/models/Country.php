<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_country".
 *
 * @property integer $id
 * @property string $country
 * @property string $country_code
 * @property integer $region_id
 * @property integer $active
 * @property string $file_path
 * @property integer $added_at
 * @property integer $updated_at
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'region_id'], 'required'],
            [['region_id', 'active', 'added_at', 'updated_at'], 'integer'],
            [['country'], 'string', 'max' => 100],
            [['country_code'], 'string', 'max' => 10],
            [['file_path'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country' => Yii::t('app', 'Country'),
            'country_code' => Yii::t('app', 'Country Code'),
            'region_id' => Yii::t('app', 'Region'),
            'active' => Yii::t('app', 'Active'),
            'file_path' => Yii::t('app', 'File Path'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function getRegion()
    {
    	return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}

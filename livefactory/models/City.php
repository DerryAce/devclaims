<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_city".
 *
 * @property integer $id
 * @property string $city
 * @property string $city_code
 * @property integer $state_id
 * @property integer $country_id
 * @property integer $active
 * @property integer $added_at
 * @property integer $updated_at
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'state_id', 'active'], 'required'],
            [['state_id', 'country_id', 'active', 'added_at', 'updated_at'], 'integer'],
            [['city', 'city_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city' => Yii::t('app', 'City'),
            'city_code' => Yii::t('app', 'City Code'),
            'state_id' => Yii::t('app', 'State'),
            'country_id' => Yii::t('app', 'Country'),
            'active' => Yii::t('app', 'Active'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function getCountry()
    {
    	return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
    
    public function getState()
    {
    	return $this->hasOne(State::className(), ['id' => 'state_id']);
    }
}

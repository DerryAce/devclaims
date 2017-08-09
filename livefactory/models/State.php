<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_state".
 *
 * @property integer $id
 * @property string $state
 * @property string $state_code
 * @property integer $country_id
 * @property integer $active
 * @property integer $added_at
 * @property integer $updated_at
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'country_id'], 'required'],
            [['country_id', 'active', 'added_at', 'updated_at'], 'integer'],
            [['state', 'state_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'state' => Yii::t('app', 'State'),
            'state_code' => Yii::t('app', 'State Code'),
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
}

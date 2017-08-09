<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_currency".
 *
 * @property integer $id
 * @property string $currency
 * @property string $alphabetic_code
 * @property string $numeric_code
 * @property string $minor_unit
 * @property integer $status
 * @property integer $added_at
 * @property integer $updated_at
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'currency', 'alphabetic_code', 'numeric_code'], 'required'],
            [['status'], 'integer'],
            [['currency', 'alphabetic_code', 'numeric_code', 'minor_unit', 'added_at', 'updated_at'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'currency' => Yii::t('app', 'Nature of Claim'),
            'alphabetic_code' => Yii::t('app', 'Alphabetic Code'),
            'numeric_code' => Yii::t('app', 'Numeric Code'),
            'minor_unit' => Yii::t('app', 'Minor Unit'),
            'status' => Yii::t('app', 'Status'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

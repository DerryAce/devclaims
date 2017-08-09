<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_company".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $company_email
 * @property string $company_phone
 * @property string $company_mobile
 * @property string $company_fax
 * @property integer $address_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'company_email', 'company_phone', 'company_mobile', 'company_fax'], 'required'],
            [['address_id', 'created_at', 'updated_at'], 'integer'],
            [['company_name', 'company_email', 'company_phone', 'company_mobile', 'company_fax'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_email' => Yii::t('app', 'Company Email'),
            'company_phone' => Yii::t('app', 'Company Phone'),
            'company_mobile' => Yii::t('app', 'Company Mobile'),
            'company_fax' => Yii::t('app', 'Company Fax'),
            'address_id' => Yii::t('app', 'Address ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

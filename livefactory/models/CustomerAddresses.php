<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_task_priority".
 *
 * @property integer $id
 * @property string $priority
 * @property string $label
 * @property integer $sort_order
 * @property integer $added_at
 * @property integer $modified_at
 * @property integer $active
 */
class CustomerAddresses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_customer_addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_id', 'customer_id'], 'required'],
            [['created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address_id' => Yii::t('app', 'Address'),
            'customer_id' => Yii::t('app', 'Customer'),
            'created_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Modified At'),
        ];
    }
	public function getAddress()
    {
    	return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }
}

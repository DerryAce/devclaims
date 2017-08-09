<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_employee".
 *
 * @property integer $id
 * @property string $employee_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property integer $mobile
 * @property integer $fax
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'first_name', 'middle_name', 'last_name', 'phone', 'user_id', 'created_at', 'updated_at'], 'required'],
            [['mobile', 'fax', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['employee_id', 'first_name', 'last_name', 'email', 'phone'], 'string', 'max' => 255],
            [['middle_name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'employee_id' => Yii::t('app', 'Employee ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'mobile' => Yii::t('app', 'Mobile'),
            'fax' => Yii::t('app', 'Fax'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

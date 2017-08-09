<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_employee_type".
 *
 * @property integer $id
 * @property string $type
 * @property integer $active
 * @property integer $added_at
 * @property integer $updated_at
 */
class EmployeeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_employee_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'added_at', 'updated_at'], 'required'],
            [['active', 'added_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'active' => Yii::t('app', 'Active'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

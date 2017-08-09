<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_status".
 *
 * @property integer $id
 * @property string $status
 * @property string $label
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'label'], 'required'],
            [['status'], 'string', 'max' => 255],
            [['label'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'label' => Yii::t('app', 'Label'),
        ];
    }
}

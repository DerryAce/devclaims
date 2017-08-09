<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_lead_source".
 *
 * @property integer $id
 * @property string $source
 * @property string $label
 * @property integer $sort_order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class LeadSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_lead_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source', 'label', 'sort_order'], 'required'],
            [['sort_order', 'status', 'created_at', 'updated_at'], 'integer'],
            [['source'], 'string', 'max' => 255],
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
            'source' => Yii::t('app', 'Source'),
            'label' => Yii::t('app', 'Label'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

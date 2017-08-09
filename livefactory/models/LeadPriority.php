<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_lead_priority".
 *
 * @property integer $id
 * @property string $priority
 * @property string $label
 * @property integer $sort_order
 * @property integer $added_at
 * @property integer $modified_at
 * @property integer $active
 */
class LeadPriority extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_lead_priority';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priority', 'label', 'sort_order', 'active'], 'required'],
            [['sort_order', 'added_at', 'modified_at', 'active'], 'integer'],
            [['priority', 'label'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'priority' => Yii::t('app', 'Priority'),
            'label' => Yii::t('app', 'Label'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'added_at' => Yii::t('app', 'Added At'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'active' => Yii::t('app', 'Active'),
        ];
    }
}

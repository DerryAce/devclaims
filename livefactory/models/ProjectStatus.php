<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_project_status".
 *
 * @property string $id
 * @property string $status
 * @property string $label
 * @property integer $sort_order
 * @property integer $active
 * @property integer $added_at
 * @property integer $modified_at
 */
class ProjectStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_project_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'sort_order', 'active'], 'required'],
            [['sort_order', 'active', 'added_at', 'modified_at'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['label'], 'string', 'max' => 50]
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
            'sort_order' => Yii::t('app', 'Sort Order'),
            'active' => Yii::t('app', 'Active'),
            'added_at' => Yii::t('app', 'Added At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }
}

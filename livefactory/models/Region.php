<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_region".
 *
 * @property integer $id
 * @property string $region
 * @property integer $active
 * @property string $file_path
 * @property integer $added_at
 * @property integer $updated_at
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'added_at', 'updated_at'], 'integer'],
            [['added_at', 'updated_at'], 'required'],
            [['region'], 'string', 'max' => 100],
            [['file_path'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'region' => Yii::t('app', 'Region'),
            'active' => Yii::t('app', 'Active'),
            'file_path' => Yii::t('app', 'File Path'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

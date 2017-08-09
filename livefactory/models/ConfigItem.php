<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_config_item".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $config_item_name
 * @property string $config_item_value
 * @property string $config_item_description
 * @property integer $active
 */
class ConfigItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_config_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['config_item_name', 'config_item_value', 'config_item_description', 'active'], 'required'],
            [['created_at', 'updated_at', 'active'], 'integer'],
            [['config_item_name', 'config_item_value', 'config_item_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'config_item_name' => Yii::t('app', 'Config Item Name'),
            'config_item_value' => Yii::t('app', 'Config Item Value'),
            'config_item_description' => Yii::t('app', 'Config Item Description'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

	public static function findByName($config_item_name)
	{
		return static::findOne ( [ 
				'config_item_name' => $config_item_name
		] );
	}
}

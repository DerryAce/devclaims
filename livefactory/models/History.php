<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_history".
 *
 * @property string $id
 * @property integer $entity_id
 * @property string $entity_type
 * @property string $notes
 * @property integer $added_at
 * @property integer $updated_at
 * @property integer $user_id
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'entity_type', 'notes', 'added_at', 'user_id'], 'required'],
            [['entity_id', 'added_at', 'updated_at', 'user_id'], 'integer'],
            [['notes'], 'string'],
            [['entity_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'entity_id' => Yii::t('app', 'Entity ID'),
            'entity_type' => Yii::t('app', 'Entity Type'),
            'notes' => Yii::t('app', 'History'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
	public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

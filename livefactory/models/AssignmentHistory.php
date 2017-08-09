<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_assignment_history".
 *
 * @property string $id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $from
 * @property string $to
 * @property integer $entity_id
 * @property string $entity_type
 * @property string $notes
 * @property integer $added_at
 * @property integer $updated_at
 * @property integer $assigned_by_user_id
 */
class AssignmentHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_assignment_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'entity_id', 'added_at', 'updated_at', 'assigned_by_user_id'], 'integer'],
            [['entity_id', 'entity_type', 'added_at'], 'required'],
            /*[['from', 'to'], 'safe'],*/
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
            'from_user_id' => Yii::t('app', 'From User ID'),
            'to_user_id' => Yii::t('app', 'To User ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'entity_id' => Yii::t('app', 'Entity ID'),
            'entity_type' => Yii::t('app', 'Entity Type'),
            'notes' => Yii::t('app', 'Notes'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'assigned_by_user_id' => Yii::t('app', 'Assigned By User ID'),
        ];
    }
	public function getUser1()
    {
    	return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }
	
	public function getUser2()
    {
    	return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }
	
	public function getUser3()
    {
    	return $this->hasOne(User::className(), ['id' => 'assigned_by_user_id']);
    }
}

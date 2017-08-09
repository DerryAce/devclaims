<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_task_time".
 *
 * @property integer $id
 * @property string $start_time
 * @property string $end_time
 * @property integer $task_id
 * @property integer $user_id
 * @property string $entry_type
 * @property integer $added_at
 * @property integer $modified_by_user_id
 * @property integer $modified_at
 */
class TaskTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_task_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'task_id', 'user_id', 'entry_type', 'added_at'], 'required'],
            [['start_time', 'end_time'], 'safe'],
            [['task_id', 'user_id', 'added_at', 'modified_by_user_id', 'modified_at'], 'integer'],
            [['entry_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'task_id' => Yii::t('app', 'Task ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'entry_type' => Yii::t('app', 'Entry Type'),
            'added_at' => Yii::t('app', 'Added At'),
            'modified_by_user_id' => Yii::t('app', 'Modified By User ID'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }
	public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

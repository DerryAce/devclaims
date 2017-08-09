<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_task".
 *
 * @property integer $id
 * @property string $task_id
 * @property string $task_name
 * @property string $task_description
 * @property string $actual_end_datetime
 * @property string $actual_start_datetime
 * @property string $time_spent
 * @property integer $assigned_user_id
 * @property integer $payment_rate
 * @property integer $project_id
 * @property string $expected_start_datetime
 * @property string $expected_end_datetime
 * @property integer $task_status_id
 * @property integer $task_priority_id
 * @property string $date_added
 * @property string $date_modified
 * @property integer $progress
 * @property integer $parent_id
 */
class SessionDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_session_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id',  'session_id'], 'required'],
            [['session_id','location_ip'], 'string'],
            [['logged_out', 'logged_in','last_logged'], 'safe'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'last_logged' => Yii::t('app', 'Last Logged'),
            'logged_out' => Yii::t('app', 'Logged Out'),
            'logged_in' => Yii::t('app', 'Logged In'),
            'location_ip' => Yii::t('app', 'Location'),
            'session_id' => Yii::t('app', 'Session Id'),
            'user_id' => Yii::t('app', 'User'),
        ];
    }
	public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

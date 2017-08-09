<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_defect".
 *
 * @property integer $id
 * @property string $defect_id
 * @property string $defect_name
 * @property string $defect_description
 * @property string $actual_end_datetime
 * @property string $actual_start_datetime
 * @property string $time_spent
 * @property integer $assigned_user_id
 * @property integer $payment_rate
 * @property integer $project_id
 * @property string $expected_start_datetime
 * @property string $expected_end_datetime
 * @property integer $defect_status_id
 * @property integer $defect_priority_id
 * @property string $date_added
 * @property string $date_modified
 * @property integer $progress
 * @property integer $parent_id
 */
class Defect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_defect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['defect_name',  'project_id', 'defect_status_id', 'defect_priority_id','defect_description', 'expected_end_datetime','expected_start_datetime'], 'required'],
            [['defect_description'], 'string'],
            [['actual_end_datetime', 'actual_start_datetime','date_added', 'date_modified'], 'safe'],
            [['time_spent'], 'number'],
            [['assigned_user_id', 'payment_rate', 'project_id', 'defect_status_id', 'defect_priority_id', 'progress', 'parent_id'], 'integer'],
            [['defect_id'], 'string', 'max' => 255],
            [['defect_name'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'defect_id' => Yii::t('app', 'Defect ID'),
            'defect_name' => Yii::t('app', 'Defect Name'),
            'defect_description' => Yii::t('app', 'Defect Description'),
            'actual_end_datetime' => Yii::t('app', 'Completion Time'),
            'actual_start_datetime' => Yii::t('app', 'Start Time'),
            'time_spent' => Yii::t('app', 'Time Spent'),
            'assigned_user_id' => Yii::t('app', 'Assigned User'),
            'payment_rate' => Yii::t('app', 'Payment Rate'),
            'project_id' => Yii::t('app', 'Project'),
            'expected_start_datetime' => Yii::t('app', 'Expected Start Date'),
            'expected_end_datetime' => Yii::t('app', 'Expected Completion Date'),
            'defect_status_id' => Yii::t('app', 'Defect Status'),
            'defect_priority_id' => Yii::t('app', 'Defect Priority'),
            'date_added' => Yii::t('app', 'Date Added'),
            'date_modified' => Yii::t('app', 'Date Modified'),
            'progress' => Yii::t('app', 'Progress'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }
	public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'assigned_user_id']);
    }
	public function getDefectPriority()
    {
    	return $this->hasOne(DefectPriority::className(), ['id' => 'defect_priority_id']);
    }
	public function getDefectStatus()
    {
    	return $this->hasOne(DefectStatus::className(), ['id' => 'defect_status_id']);
    }
	public function getProject()
    {
    	return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
	public function getDefect()
    {
    	return $this->hasOne(Defect::className(), ['id' => 'entity_id']);
    }
	public function getDefectParent()
    {
    	return $this->hasOne(Defect::className(), ['id' => 'parent_id']);
    }
}

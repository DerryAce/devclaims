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

class Task extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'lot_task';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['task_name',  'project_id', 'task_status_id', 'task_priority_id','task_description', 'expected_end_datetime','expected_start_datetime'], 'required'],

            [['task_description'], 'string'],

            [['actual_end_datetime', 'actual_start_datetime','date_added', 'date_modified'], 'safe'],

            [['time_spent'], 'number'],

            [['assigned_user_id', 'payment_rate', 'project_id', 'task_status_id', 'task_priority_id', 'progress', 'parent_id'], 'integer'],

            [['task_id'], 'string', 'max' => 255],

            [['task_name'], 'string', 'max' => 1024]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'task_id' => Yii::t('app', 'Internal ID'),

            'task_name' => Yii::t('app', 'Incident ID'),

            'task_description' => Yii::t('app', 'CIC Comments'),

            'actual_end_datetime' => Yii::t('app', 'Cheque Date'),

            'actual_start_datetime' => Yii::t('app', 'Cheque Number'),

            'time_spent' => Yii::t('app', 'Time Spent'),

            'assigned_user_id' => Yii::t('app', 'Assigned User'),

            'payment_rate' => Yii::t('app', 'Payment Rate'),

            'project_id' => Yii::t('app', 'Claim'),

            'expected_start_datetime' => Yii::t('app', 'Paid On'),

            'expected_end_datetime' => Yii::t('app', 'Expected Completion Date'),

            'task_status_id' => Yii::t('app', 'Incident Status'),

            'task_priority_id' => Yii::t('app', 'DV Priority'),

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

	public function getTaskPriority()

    {

    	return $this->hasOne(TaskPriority::className(), ['id' => 'task_priority_id']);

    }

	public function getTaskStatus()

    {

    	return $this->hasOne(TaskStatus::className(), ['id' => 'task_status_id']);

    }

	public function getProject()

    {

    	return $this->hasOne(Project::className(), ['id' => 'project_id']);

    }

	public function getTask()

    {

    	return $this->hasOne(Task::className(), ['id' => 'entity_id']);

    }

	public function getTaskParent()

    {

    	return $this->hasOne(Task::className(), ['id' => 'parent_id']);

    }

}


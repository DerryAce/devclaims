<?php



namespace livefactory\models;



use Yii;



/**

 * This is the model class for table "lot_lead".

 *

 * @property integer $id

 * @property string $lead_id

 * @property string $lead_title

 * @property string $lead_description

 * @property string $actual_end_datetime

 * @property string $actual_start_datetime

 * @property string $time_spent

 * @property integer $assigned_user_id

 * @property string $budget

 * @property integer $customer_id

 * @property string $expected_start_datetime

 * @property string $expected_end_datetime

 * @property integer $lead_status_id

 * @property integer $lead_priority_id

 * @property integer $lead_type_id

 * @property string $date_added

 * @property string $date_modified

 * @property integer $progress

 * @property integer $parent_id

 * @property integer $added_at

 * @property integer $updated_at

 */

class Lead extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'lot_lead';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['lead_title', 'lead_description',  'assigned_user_id',  'customer_id','expected_start_datetime', 'expected_end_datetime',  'lead_type_id'], 'required'],

            [['lead_description'], 'string'],

            [['actual_end_datetime', 'actual_start_datetime', 'expected_start_datetime', 'expected_end_datetime', 'date_added', 'date_modified'], 'safe'],

            [['assigned_user_id', 'customer_id', 'lead_status_id', 'lead_source_id', 'lead_priority_id', 'lead_type_id', 'progress', 'parent_id', 'added_at', 'updated_at'], 'integer'],

            [['lead_id', 'budget'], 'string', 'max' => 255],

            [['lead_title'], 'string', 'max' => 1024],

            [['time_spent'], 'string', 'max' => 20]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'lead_id' => Yii::t('app', 'Lead ID'),

            'lead_title' => Yii::t('app', 'Lead Title'),

            'lead_description' => Yii::t('app', 'Lead Description'),

           'actual_end_datetime' => Yii::t('app', 'Completion Time'),

            'actual_start_datetime' => Yii::t('app', 'Start Time'),

            'time_spent' => Yii::t('app', 'Time Spent'),

            'assigned_user_id' => Yii::t('app', 'Assigned User'),

			'lead_source_id' => Yii::t('app', 'Lead Source'),

            'budget' => Yii::t('app', 'Budget'),

            'customer_id' => Yii::t('app', 'Customer'),

            'expected_start_datetime' => Yii::t('app', 'Expected Start Date'),

            'expected_end_datetime' => Yii::t('app', 'Expected Completion Date'),

            'lead_status_id' => Yii::t('app', 'Lead Status'),

            'lead_priority_id' => Yii::t('app', 'Lead Priority'),

            'lead_type_id' => Yii::t('app', 'Lead Type'),

            'date_added' => Yii::t('app', 'Date Added'),

            'date_modified' => Yii::t('app', 'Date Modified'),

            'progress' => Yii::t('app', 'Progress'),

            'parent_id' => Yii::t('app', 'Parent'),

            'added_at' => Yii::t('app', 'Added At'),

            'updated_at' => Yii::t('app', 'Updated At'),

        ];

    }

	public function getUser()

    {

    	return $this->hasOne(User::className(), ['id' => 'assigned_user_id']);

    }

	public function getLeadPriority()

    {

    	return $this->hasOne(LeadPriority::className(), ['id' => 'lead_priority_id']);

    }

	public function getLeadStatus()

    {

    	return $this->hasOne(LeadStatus::className(), ['id' => 'lead_status_id']);

    }

	public function getLeadSource()

    {

    	return $this->hasOne(LeadSource::className(), ['id' => 'lead_source_id']);

    }

	public function getLead()

    {

    	return $this->hasOne(Lead::className(), ['id' => 'entity_id']);

    }

	public function getLeadParent()

    {

    	return $this->hasOne(Lead::className(), ['id' => 'parent_id']);

    }

	public function getCustomer()

    {

    	return $this->hasOne(Customer::className(), ['id' => 'customer_id']);

    }

}


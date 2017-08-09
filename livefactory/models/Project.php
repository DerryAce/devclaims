<?php



namespace livefactory\models;

use livefactory\models\ProjectUser as ProjectUserModel;

use Yii;



/**

 * This is the model class for table "lot_project".

 *

 * @property integer $id

 * @property integer $parent_project_id

 * @property integer $project_type_id

 * @property string $project_name

 * @property integer $added_by

 * @property integer $last_updated_by

 * @property integer $project_owner

 * @property integer $added_at

 * @property integer $update_at

 * @property string $expected_start_date

 * @property string $expected_end_date

 * @property string $actual_start_date

 * @property string $actual_end_date

 * @property string $project_description

 * @property string $project_budget

 * @property integer $project_currency

 * @property integer $customer_id

 * @property integer $project_status_id

 */

class Project extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'lot_project';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [[ 'project_type_id', 'added_by',  'project_owner',  'project_currency', 'customer_id', 'project_status_id','project_budget','progress'], 'integer'],

            [['project_name', 'project_description', 'customer_id'], 'required'],

            [['expected_start_date', 'expected_end_date', 'actual_start_date', 'actual_end_date'], 'safe'],

            [['project_description'], 'string'],

            

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'parent_project_id' => Yii::t('app', 'Parent Claim'),

            'project_type_id' => Yii::t('app', 'Position'),

            'project_name' => Yii::t('app', 'Claim ID'),

            'added_by' => Yii::t('app', 'Added By'),

            'last_updated_by' => Yii::t('app', 'Last Updated By'),

            'project_owner' => Yii::t('app', 'Assigned User'),

            'added_at' => Yii::t('app', 'Added At'),

            'update_at' => Yii::t('app', 'Update At'),

            'expected_start_date' => Yii::t('app', 'Date of Loss'),

            'expected_end_date' => Yii::t('app', 'Date Appointed'),

            'actual_start_date' => Yii::t('app', 'Preliminary Report'),

            'actual_end_date' => Yii::t('app', 'Final Report'),

            'project_description' => Yii::t('app', 'UTMOST Comments'),

            'project_budget' => Yii::t('app', 'Amount'),

            'project_currency' => Yii::t('app', 'Nature of Claim'),

            'customer_id' => Yii::t('app', 'Client'),

            'project_status_id' => Yii::t('app', 'Loss Adjusters Report'),

        ];

    }

	public function getUser()

    {

    	return $this->hasOne(User::className(), ['id' => 'added_by']);

    }

	public function getUser1()

    {

    	return $this->hasOne(User::className(), ['id' => 'project_owner']);

    }

	public function getStatus()

    {

    	return $this->hasOne(ProjectStatus::className(), ['id' => 'project_status_id']);

    }

	public function getCustomer()

    {

    	return $this->hasOne(Customer::className(), ['id' => 'customer_id']);

    }

	public function getType()

    {

    	return $this->hasOne(ProjectType::className(), ['id' => 'project_type_id']);

    }

	public function getOpentask()

	{

		return $this->hasMany(Task::className(), ['project_id' => 'id'])->andWhere('task_status_id=1 OR task_status_id=5')->count();

	}

	public function getUsers()

	{

		return $this->hasMany(ProjectUser::className(), ['project_id' => 'id'])->count();

	}

	public static  function getProjectUsers($entity_id)

	{

		$dataProvider = ProjectUserModel::find ()->where ( [

				'project_id' => $entity_id 

		] )->asArray()->all();

		

		return $dataProvider;

	}

}


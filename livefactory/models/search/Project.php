<?php



namespace livefactory\models\search;



use Yii;

use yii\base\Model;

use yii\data\ActiveDataProvider;

use livefactory\models\Project as ProjectModel;

use livefactory\models\ProjectUser as ProjectUserModel;

use livefactory\models\File as FileModel;

use livefactory\models\Note as NoteModel;

use livefactory\models\Task as TaskModel;

use livefactory\models\History as HistoryModel;

use livefactory\models\Defect as DefectModel;

use livefactory\models\AssignmentHistory as AssignmentHistoryModel;



/**

 * Project represents the model behind the search form about `livefactory\models\Project`.

 */

class Project extends ProjectModel

{

	public $entity_type_value='project';

    public function rules()

    {

        return [

            [['id', 'parent_project_id', 'project_type_id', 'added_by', 'last_updated_by', 'project_owner', 'added_at', 'update_at', 'project_currency', 'customer_id', 'project_status_id'], 'integer'],

            [['project_name', 'expected_start_date', 'expected_end_date', 'actual_start_date', 'actual_end_date', 'project_description', 'project_budget'], 'safe'],

        ];

    }



    public function scenarios()

    {

        // bypass scenarios() implementation in the parent class

        return Model::scenarios();

    }



    public function search($params)

    {

        $query = ProjectModel::find();

		if(Yii::$app->user->identity->user_role_id !='1'){

			$query = ProjectModel::find()->where("EXISTS(Select *

FROM lot_project_user  WHERE project_id =lot_project.id and user_id=".Yii::$app->user->identity->id.")");

		}

        $dataProvider = new ActiveDataProvider([

            'query' => $query,

        ]);



        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,

            'parent_project_id' => $this->parent_project_id,

            'project_type_id' => $this->project_type_id,

            'added_by' => $this->added_by,

            'last_updated_by' => $this->last_updated_by,

            'project_owner' => $this->project_owner,

            'added_at' => $this->added_at,

            'update_at' => $this->update_at,

            'expected_start_date' => $this->expected_start_date,

            'expected_end_date' => $this->expected_end_date,

            'actual_start_date' => $this->actual_start_date,

            'actual_end_date' => $this->actual_end_date,

            'project_currency' => $this->project_currency,

            'customer_id' => $this->customer_id,

            'project_status_id' => $this->project_status_id,

        ]);



        $query->andFilterWhere(['like', 'project_name', $this->project_name])

            ->andFilterWhere(['like', 'project_description', $this->project_description])

            ->andFilterWhere(['like', 'project_budget', $this->project_budget]);



        return $dataProvider;

    }

	public function searchTask($params, $entity_id)

	{

		if($_GET['tasktab']){

						$query = TaskModel::find ()->where ( [ 

					'project_id' => $entity_id 

			] )->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order')->where("task_status_id='5' OR  task_status_id='1'");

	

		}else{

			$query = TaskModel::find ()->where ( [ 

					'project_id' => $entity_id 

			] )->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order');

		}

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}

		

		return $dataProvider;

	}
	
	public function searchDefect($params, $entity_id)

	{

			$query = DefectModel::find ()->where ( [ 

					'project_id' => $entity_id 

			] )->joinWith('defectStatus')->joinWith('defectPriority')->orderBy('lot_defect_status.sort_order,lot_defect_priority.sort_order');

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}

		

		return $dataProvider;

	}

	public function searchProjectUser($params, $entity_id)

	{

		$query = ProjectUserModel::find ()->where ( [

				'project_id' => $entity_id 

		] );

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}

		

		return $dataProvider;

	}

	

}


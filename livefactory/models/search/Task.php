<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Task as TaskModel;
use livefactory\models\File as FileModel;
use livefactory\models\Note as NoteModel;
use livefactory\models\TaskTime as TaskTimeModel;
use livefactory\models\TimeEntry;
use livefactory\models\History as HistoryModel;
use livefactory\models\AssignmentHistory as AssignmentHistoryModel;

/**
 * Task represents the model behind the search form about `livefactory\models\Task`.
 */
class Task extends TaskModel
{
	public $entity_type_value='task';
	public function rules()
	{
		return [ 
				[ 
						[ 
								'id',
								'assigned_user_id',
								'payment_rate',
								'project_id',
								'task_status_id',
								'task_priority_id',
								'progress',
								'parent_id',
								'added_at',
								'updated_at' 
						],
						'integer' 
				],
				[ 
						[ 
								'task_id',
								'task_name',
								'task_description',
								'actual_end_datetime',
								'actual_start_datetime',
								'expected_start_datetime',
								'expected_end_datetime',
								'date_added',
								'date_modified' 
						],
						'safe' 
				],
				[ 
						[ 
								'time_spent' 
						],
						'number' 
				] 
		];
	}
	
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios ();
	}
	
	public function search($params)
	{
		
		$query = TaskModel::find()->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order');
		if(Yii::$app->user->identity->user_role_id !='1'){
			$query = TaskModel::find()->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order')->where(" EXISTS(Select *
FROM lot_project_user  WHERE project_id =lot_task.project_id and user_id=".Yii::$app->user->identity->id.")");
		}
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query,
		] );
		
		if (! ($this->load ( $params ) && $this->validate ()))
		{
			return $dataProvider;
		}
		
		$query->andFilterWhere ( [ 
				'id' => $this->id,
				'actual_end_datetime' => $this->actual_end_datetime,
				'actual_start_datetime' => $this->actual_start_datetime,
				'time_spent' => $this->time_spent,
				'assigned_user_id' => $this->assigned_user_id,
				'payment_rate' => $this->payment_rate,
				'project_id' => $this->project_id,
				'expected_start_datetime' => $this->expected_start_datetime,
				'expected_end_datetime' => $this->expected_end_datetime,
				'task_status_id' => $this->task_status_id,
				'task_priority_id' => $this->task_priority_id,
				'date_added' => $this->date_added,
				'date_modified' => $this->date_modified,
				'progress' => $this->progress,
				'parent_id' => $this->parent_id,
				'added_at' => $this->added_at,
				'updated_at' => $this->updated_at 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'task_id',
				$this->task_id 
		] )->andFilterWhere ( [ 
				'like',
				'task_name',
				$this->task_name 
		] )->andFilterWhere ( [ 
				'like',
				'task_description',
				$this->task_description 
		] );
		
		$query->orderBy ( 'task_status_id' );
		
		return $dataProvider;
	}
	public function searchNeedActions($params)
	{
		
		$query = TaskModel::find()->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order')->where("task_status_id=5 or task_status_id=1");
		if(Yii::$app->user->identity->user_role_id !='1'){
			$query = TaskModel::find()->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order')->where("(task_status_id=5 or task_status_id=1) and EXISTS(Select *
FROM lot_project_user  WHERE project_id =lot_task.project_id and user_id=".Yii::$app->user->identity->id.")");
		}
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query,
		] );
		
		if (! ($this->load ( $params ) && $this->validate ()))
		{
			return $dataProvider;
		}
		
		$query->andFilterWhere ( [ 
				'id' => $this->id,
				'actual_end_datetime' => $this->actual_end_datetime,
				'actual_start_datetime' => $this->actual_start_datetime,
				'time_spent' => $this->time_spent,
				'assigned_user_id' => $this->assigned_user_id,
				'payment_rate' => $this->payment_rate,
				'project_id' => $this->project_id,
				'expected_start_datetime' => $this->expected_start_datetime,
				'expected_end_datetime' => $this->expected_end_datetime,
				'task_status_id' => $this->task_status_id,
				'task_priority_id' => $this->task_priority_id,
				'date_added' => $this->date_added,
				'date_modified' => $this->date_modified,
				'progress' => $this->progress,
				'parent_id' => $this->parent_id,
				'added_at' => $this->added_at,
				'updated_at' => $this->updated_at 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'task_id',
				$this->task_id 
		] )->andFilterWhere ( [ 
				'like',
				'task_name',
				$this->task_name 
		] )->andFilterWhere ( [ 
				'like',
				'task_description',
				$this->task_description 
		] );
		
		$query->orderBy ( 'task_status_id' );
		
		return $dataProvider;
	}
	public function searchMyTasks($params)
	{
			$query = TaskModel::find()->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order')->where("assigned_user_id=".Yii::$app->user->identity->id);
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query,
		] );
		
		if (! ($this->load ( $params ) && $this->validate ()))
		{
			return $dataProvider;
		}
		
		$query->andFilterWhere ( [ 
				'id' => $this->id,
				'actual_end_datetime' => $this->actual_end_datetime,
				'actual_start_datetime' => $this->actual_start_datetime,
				'time_spent' => $this->time_spent,
				'assigned_user_id' => $this->assigned_user_id,
				'payment_rate' => $this->payment_rate,
				'project_id' => $this->project_id,
				'expected_start_datetime' => $this->expected_start_datetime,
				'expected_end_datetime' => $this->expected_end_datetime,
				'task_status_id' => $this->task_status_id,
				'task_priority_id' => $this->task_priority_id,
				'date_added' => $this->date_added,
				'date_modified' => $this->date_modified,
				'progress' => $this->progress,
				'parent_id' => $this->parent_id,
				'added_at' => $this->added_at,
				'updated_at' => $this->updated_at 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'task_id',
				$this->task_id 
		] )->andFilterWhere ( [ 
				'like',
				'task_name',
				$this->task_name 
		] )->andFilterWhere ( [ 
				'like',
				'task_description',
				$this->task_description 
		] );
		
		$query->orderBy ( 'task_status_id' );
		
		return $dataProvider;
	}
	public function searchSubTask($params, $entity_id)
	{
		$query = TaskModel::find ()->where ( [ 
				'parent_id' => $entity_id 
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
	public function searchTaskTime($params, $entity_id)
	{
		$query = TimeEntry::find()->where ( [ 
				'entity_id' => $entity_id,
				'entity_type'=>'task' 
		] )->orderBy('end_time DESC');
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query 
		] );
		
		if (! ($this->load ( $params ) && $this->validate ()))
		{
			return $dataProvider;
		}
		
		return $dataProvider;
	}
	public static function getSubTaskCount($entity_id)
	{
		return TaskModel::find ()->where ( [ 
				'parent_id' => $entity_id 
		] )->count();
	}
}

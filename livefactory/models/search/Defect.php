<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Defect as DefectModel;
use livefactory\models\File as FileModel;
use livefactory\models\Note as NoteModel;
use livefactory\models\DefectTime as DefectTimeModel;
use livefactory\models\TimeEntry;
use livefactory\models\History as HistoryModel;
use livefactory\models\AssignmentHistory as AssignmentHistoryModel;

/**
 * Defect represents the model behind the search form about `livefactory\models\Defect`.
 */
class Defect extends DefectModel
{
	public $entity_type_value='defect';
	public function rules()
	{
		return [ 
				[ 
						[ 
								'id',
								'assigned_user_id',
								'payment_rate',
								'project_id',
								'defect_status_id',
								'defect_priority_id',
								'progress',
								'parent_id',
								'added_at',
								'updated_at' 
						],
						'integer' 
				],
				[ 
						[ 
								'defect_id',
								'defect_name',
								'defect_description',
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
		
		$query = DefectModel::find()->joinWith('defectStatus')->joinWith('defectPriority')->orderBy('lot_defect_status.sort_order,lot_defect_priority.sort_order');
		if(Yii::$app->user->identity->user_role_id !='1'){
			$query = DefectModel::find()->joinWith('defectStatus')->joinWith('defectPriority')->orderBy('lot_defect_status.sort_order,lot_defect_priority.sort_order')->where(" EXISTS(Select *
FROM lot_project_user  WHERE project_id =lot_defect.project_id and user_id=".Yii::$app->user->identity->id.")");
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
				'defect_status_id' => $this->defect_status_id,
				'defect_priority_id' => $this->defect_priority_id,
				'date_added' => $this->date_added,
				'date_modified' => $this->date_modified,
				'progress' => $this->progress,
				'parent_id' => $this->parent_id,
				'added_at' => $this->added_at,
				'updated_at' => $this->updated_at 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'defect_id',
				$this->defect_id 
		] )->andFilterWhere ( [ 
				'like',
				'defect_name',
				$this->defect_name 
		] )->andFilterWhere ( [ 
				'like',
				'defect_description',
				$this->defect_description 
		] );
		
		$query->orderBy ( 'defect_status_id' );
		
		return $dataProvider;
	}
	public function searchNeedActions($params)
	{
		
		$query = DefectModel::find()->joinWith('defectStatus')->joinWith('defectPriority')->orderBy('lot_defect_status.sort_order,lot_defect_priority.sort_order')->where("defect_status_id=5 or defect_status_id=1");
		if(Yii::$app->user->identity->user_role_id !='1'){
			$query = DefectModel::find()->joinWith('defectStatus')->joinWith('defectPriority')->orderBy('lot_defect_status.sort_order,lot_defect_priority.sort_order')->where("(defect_status_id=5 or defect_status_id=1) and EXISTS(Select *
FROM lot_project_user  WHERE project_id =lot_defect.project_id and user_id=".Yii::$app->user->identity->id.")");
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
				'defect_status_id' => $this->defect_status_id,
				'defect_priority_id' => $this->defect_priority_id,
				'date_added' => $this->date_added,
				'date_modified' => $this->date_modified,
				'progress' => $this->progress,
				'parent_id' => $this->parent_id,
				'added_at' => $this->added_at,
				'updated_at' => $this->updated_at 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'defect_id',
				$this->defect_id 
		] )->andFilterWhere ( [ 
				'like',
				'defect_name',
				$this->defect_name 
		] )->andFilterWhere ( [ 
				'like',
				'defect_description',
				$this->defect_description 
		] );
		
		$query->orderBy ( 'defect_status_id' );
		
		return $dataProvider;
	}
	public function searchMyDefects($params)
	{
			$query = DefectModel::find()->joinWith('defectStatus')->joinWith('defectPriority')->orderBy('lot_defect_status.sort_order,lot_defect_priority.sort_order')->where("assigned_user_id=".Yii::$app->user->identity->id);
		
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
				'defect_status_id' => $this->defect_status_id,
				'defect_priority_id' => $this->defect_priority_id,
				'date_added' => $this->date_added,
				'date_modified' => $this->date_modified,
				'progress' => $this->progress,
				'parent_id' => $this->parent_id,
				'added_at' => $this->added_at,
				'updated_at' => $this->updated_at 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'defect_id',
				$this->defect_id 
		] )->andFilterWhere ( [ 
				'like',
				'defect_name',
				$this->defect_name 
		] )->andFilterWhere ( [ 
				'like',
				'defect_description',
				$this->defect_description 
		] );
		
		$query->orderBy ( 'defect_status_id' );
		
		return $dataProvider;
	}
	public function searchSubDefect($params, $entity_id)
	{
		$query = DefectModel::find ()->where ( [ 
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
	public function searchDefectTime($params, $entity_id)
	{
		$query = TimeEntry::find()->where ( [ 
				'entity_id' => $entity_id,
				'entity_type'=>'defect' 
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
	public static function getSubDefectCount($entity_id)
	{
		return DefectModel::find ()->where ( [ 
				'parent_id' => $entity_id 
		] )->count();
	}
}

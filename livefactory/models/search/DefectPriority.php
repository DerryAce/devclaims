<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\DefectPriority as DefectPriorityModel;

/**
 * DefectPriority represents the model behind the search form about `livefactory\models\DefectPriority`.
 */
class DefectPriority extends DefectPriorityModel
{
	public function rules()
	{
		return [ 
				[ 
						[ 
								'id',
								'sort_order',
								'added_at',
								'modified_at',
								'active' 
						],
						'integer' 
				],
				[ 
						[ 
								'priority',
								'label' 
						],
						'safe' 
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
		$query = DefectPriorityModel::find ()->orderBy('sort_order');
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query,
				'sort' => array (
						'defaultOrder' => 'sort_order ASC' 
				) 
		] );
		
		if (! ($this->load ( $params ) && $this->validate ()))
		{
			return $dataProvider;
		}
		
		$query->andFilterWhere ( [ 
				'id' => $this->id,
				'sort_order' => $this->sort_order,
				'added_at' => $this->added_at,
				'modified_at' => $this->modified_at,
				'active' => $this->active 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'priority',
				$this->priority 
		] )->andFilterWhere ( [ 
				'like',
				'label',
				$this->label 
		] );
		
		return $dataProvider;
	}
}

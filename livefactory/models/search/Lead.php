<?php



namespace livefactory\models\search;



use Yii;

use yii\base\Model;

use yii\data\ActiveDataProvider;

use livefactory\models\Lead as LeadModel;



/**

 * Lead represents the model behind the search form about `\livefactory\models\Lead`.

 */

class Lead extends LeadModel

{

    public function rules()

    {

        return [

            [['id', 'assigned_user_id', 'customer_id', 'lead_status_id', 'lead_priority_id', 'lead_type_id', 'progress', 'parent_id', 'added_at', 'updated_at'], 'integer'],

            [['lead_id', 'lead_title', 'lead_description', 'actual_end_datetime', 'actual_start_datetime', 'time_spent', 'budget', 'expected_start_datetime', 'expected_end_datetime', 'date_added', 'date_modified'], 'safe'],

        ];

    }



    public function scenarios()

    {

        // bypass scenarios() implementation in the parent class

        return Model::scenarios();

    }



    public function search($params)

    {

       $query = LeadModel::find()->joinWith('leadStatus')->joinWith('leadPriority')->orderBy('lot_lead_status.sort_order,lot_lead_priority.sort_order');

		if(Yii::$app->user->identity->user_role_id !='1'){

			$query = LeadModel::find()->joinWith('leadStatus')->joinWith('leadPriority')->orderBy('lot_lead_status.sort_order,lot_lead_priority.sort_order')->where(" EXISTS(Select *

FROM lot_project_user  WHERE project_id =lot_lead.project_id and user_id=".Yii::$app->user->identity->id.")");

		}



        $dataProvider = new ActiveDataProvider([

            'query' => $query,

        ]);



        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,

            'actual_end_datetime' => $this->actual_end_datetime,

            'actual_start_datetime' => $this->actual_start_datetime,

            'assigned_user_id' => $this->assigned_user_id,

            'customer_id' => $this->customer_id,

            'expected_start_datetime' => $this->expected_start_datetime,

            'expected_end_datetime' => $this->expected_end_datetime,

            'lead_status_id' => $this->lead_status_id,

            'lead_priority_id' => $this->lead_priority_id,

            'lead_type_id' => $this->lead_type_id,

            'date_added' => $this->date_added,

            'date_modified' => $this->date_modified,

            'progress' => $this->progress,

            'parent_id' => $this->parent_id,

            'added_at' => $this->added_at,

            'updated_at' => $this->updated_at,

        ]);



        $query->andFilterWhere(['like', 'lead_id', $this->lead_id])

            ->andFilterWhere(['like', 'lead_title', $this->lead_title])

            ->andFilterWhere(['like', 'lead_description', $this->lead_description])

            ->andFilterWhere(['like', 'time_spent', $this->time_spent])

            ->andFilterWhere(['like', 'budget', $this->budget]);



        return $dataProvider;

    }
	public function searchMyLeads($params)

    {

        $query = LeadModel::find()->joinWith('leadStatus')->joinWith('leadPriority')->orderBy('lot_lead_status.sort_order,lot_lead_priority.sort_order')->where("assigned_user_id=".Yii::$app->user->identity->id);;



        $dataProvider = new ActiveDataProvider([

            'query' => $query,

        ]);



        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,

            'actual_end_datetime' => $this->actual_end_datetime,

            'actual_start_datetime' => $this->actual_start_datetime,

            'assigned_user_id' => $this->assigned_user_id,

            'customer_id' => $this->customer_id,

            'expected_start_datetime' => $this->expected_start_datetime,

            'expected_end_datetime' => $this->expected_end_datetime,

            'lead_status_id' => $this->lead_status_id,

            'lead_priority_id' => $this->lead_priority_id,

            'lead_type_id' => $this->lead_type_id,

            'date_added' => $this->date_added,

            'date_modified' => $this->date_modified,

            'progress' => $this->progress,

            'parent_id' => $this->parent_id,

            'added_at' => $this->added_at,

            'updated_at' => $this->updated_at,

        ]);



        $query->andFilterWhere(['like', 'lead_id', $this->lead_id])

            ->andFilterWhere(['like', 'lead_title', $this->lead_title])

            ->andFilterWhere(['like', 'lead_description', $this->lead_description])

            ->andFilterWhere(['like', 'time_spent', $this->time_spent])

            ->andFilterWhere(['like', 'budget', $this->budget]);



        return $dataProvider;

    }
	public static function getSubLeadCount($entity_id)

	{

		return LeadModel::find ()->where ( [ 

				'parent_id' => $entity_id 

		] )->count();

	}
	public function searchSubLead($params, $entity_id)

	{

		$query = LeadModel::find ()->where ( [ 

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
	public function searchLeadTime($params, $entity_id)

	{

		$query = TimeEntry::find()->where ( [ 

				'entity_id' => $entity_id,

				'entity_type'=>'lead' 

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

}


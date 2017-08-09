<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\History as HistoryModel;

/**
 * History represents the model behind the search form about `livefactory\models\History`.
 */
class History extends HistoryModel
{
    public function rules()
    {
        return [
            [['id', 'entity_id', 'added_at', 'updated_at', 'user_id'], 'integer'],
            [['entity_type', 'notes'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = HistoryModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'entity_id' => $this->entity_id,
            'added_at' => $this->added_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'entity_type', $this->entity_type])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
	public function searchSessionActivities($params){
		date_default_timezone_set('asia/kolkata');
		$start =strtotime($_GET['start']);
		$end =strtotime(strpos($_GET['end'],'0000-00-00') !== false ?date('Y-m-d H:i:s'):$_GET['end']);
		//var_dump($start);
		//var_dump($end);
		$query = HistoryModel::find()->where("user_id =$_GET[id] and added_at >='$start' and added_at <='$end'")->orderBy('id DESC');
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query 
		] );
		
		if (! ($this->load ( $params ) && $this->validate ()))
		{
			return $dataProvider;
		}
		
		return $dataProvider;
		
	}
	public static function getUserActivities($id){
		return HistoryModel::find()->where("user_id=$id")->asArray()->orderBy('added_at desc')->all();
	}
}

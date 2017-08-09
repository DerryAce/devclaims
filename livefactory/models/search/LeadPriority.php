<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\LeadPriority as LeadPriorityModel;

/**
 * LeadPriority represents the model behind the search form about `\livefactory\models\LeadPriority`.
 */
class LeadPriority extends LeadPriorityModel
{
    public function rules()
    {
        return [
            [['id', 'sort_order', 'added_at', 'modified_at', 'active'], 'integer'],
            [['priority', 'label'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LeadPriorityModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'added_at' => $this->added_at,
            'modified_at' => $this->modified_at,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}

<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\LeadSource as LeadSourceModel;

/**
 * LeadSource represents the model behind the search form about `\livefactory\models\LeadSource`.
 */
class LeadSource extends LeadSourceModel
{
    public function rules()
    {
        return [
            [['id', 'sort_order', 'status', 'created_at', 'updated_at'], 'integer'],
            [['source', 'label'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LeadSourceModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}

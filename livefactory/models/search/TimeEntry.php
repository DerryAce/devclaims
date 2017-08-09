<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\TimeEntry as TimeEntryModel;

/**
 * TimeEntry represents the model behind the search form about `livefactory\models\TimeEntry`.
 */
class TimeEntry extends TimeEntryModel
{
    public function rules()
    {
        return [
            [['id', 'entity_id', 'user_id', 'added_at', 'modified_by_user_id', 'modified_at', 'approved'], 'integer'],
            [['start_time', 'end_time', 'entity_type', 'entry_type', 'notes'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TimeEntryModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'entity_id' => $this->entity_id,
            'user_id' => $this->user_id,
            'added_at' => $this->added_at,
            'modified_by_user_id' => $this->modified_by_user_id,
            'modified_at' => $this->modified_at,
            'approved' => $this->approved,
        ]);

        $query->andFilterWhere(['like', 'entity_type', $this->entity_type])
            ->andFilterWhere(['like', 'entry_type', $this->entry_type])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}

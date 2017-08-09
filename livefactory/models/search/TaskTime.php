<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\TaskTime as TaskTimeModel;

/**
 * TaskTime represents the model behind the search form about `livefactory\models\TaskTime`.
 */
class TaskTime extends TaskTimeModel
{
    public function rules()
    {
        return [
            [['id', 'task_id', 'user_id', 'added_at', 'modified_by_user_id', 'modified_at'], 'integer'],
            [['start_time', 'end_time', 'entry_type'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TaskTimeModel::find()->orderBy('start_time');

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
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
            'added_at' => $this->added_at,
            'modified_by_user_id' => $this->modified_by_user_id,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'entry_type', $this->entry_type]);

        return $dataProvider;
    }
}

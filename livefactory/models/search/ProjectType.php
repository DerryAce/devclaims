<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\ProjectType as ProjectTypeModel;

/**
 * ProjectType represents the model behind the search form about `livefactory\models\ProjectType`.
 */
class ProjectType extends ProjectTypeModel
{
    public function rules()
    {
        return [
            [['id', 'sort_order', 'active', 'added_at', 'modified_at'], 'integer'],
            [['type', 'label'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectTypeModel::find()->orderBy('sort_order');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'active' => $this->active,
            'added_at' => $this->added_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}

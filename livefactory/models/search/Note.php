<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Note as NoteModel;

/**
 * Note represents the model behind the search form about `livefactory\models\Note`.
 */
class Note extends NoteModel
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
        $query = NoteModel::find();

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
	public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

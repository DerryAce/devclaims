<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Member as MemberModel;

/**
 * Member represents the model behind the search form about `livefactory\models\Member`.
 */
class Member extends MemberModel
{
    public function rules()
    {
        return [
            [['id', 'mobile', 'fax', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'phone'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MemberModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mobile' => $this->mobile,
            'fax' => $this->fax,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}

<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Country as CountryModel;

/**
 * Country represents the model behind the search form about `livefactory\models\Country`.
 */
class Country extends CountryModel
{
    public function rules()
    {
        return [
            [['id', 'region_id', 'active', 'added_at', 'updated_at'], 'integer'],
            [['country', 'country_code', 'file_path'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CountryModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'region_id' => $this->region_id,
            'active' => $this->active,
            'added_at' => $this->added_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'country_code', $this->country_code])
            ->andFilterWhere(['like', 'file_path', $this->file_path]);

        return $dataProvider;
    }
}

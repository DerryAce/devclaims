<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Address as AddressModel;

/**
 * Address represents the model behind the search form about `livefactory\models\Address`.
 */
class Address extends AddressModel
{
    public function rules()
    {
        return [
            [['id', 'country_id', 'state_id', 'city_id', 'zipcode', 'created_at', 'updated_at'], 'integer'],
            [['address_1', 'address_2'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AddressModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'zipcode' => $this->zipcode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'address_1', $this->address_1])
            ->andFilterWhere(['like', 'address_2', $this->address_2]);

        return $dataProvider;
    }
}

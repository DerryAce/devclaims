<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Currency as CurrencyModel;

/**
 * Currency represents the model behind the search form about `\livefactory\models\Currency`.
 */
class Currency extends CurrencyModel
{
    public function rules()
    {
        return [
            [['id', 'status', 'added_at', 'updated_at'], 'integer'],
            [['currency', 'alphabetic_code', 'numeric_code', 'minor_unit'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CurrencyModel::find()->orderBy('alphabetic_code');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'added_at' => $this->added_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'alphabetic_code', $this->alphabetic_code])
            ->andFilterWhere(['like', 'numeric_code', $this->numeric_code])
            ->andFilterWhere(['like', 'minor_unit', $this->minor_unit]);

        return $dataProvider;
    }
}

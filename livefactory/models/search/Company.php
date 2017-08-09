<?php

namespace livefactory\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use livefactory\models\Company as CompanyModel;

/**
 * Company represents the model behind the search form about `\livefactory\models\Company`.
 */
class Company extends CompanyModel
{
    public function rules()
    {
        return [
            [['id', 'address_id', 'created_at', 'updated_at'], 'integer'],
            [['company_name', 'company_email', 'company_phone', 'company_mobile', 'company_fax'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CompanyModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'address_id' => $this->address_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_email', $this->company_email])
            ->andFilterWhere(['like', 'company_phone', $this->company_phone])
            ->andFilterWhere(['like', 'company_mobile', $this->company_mobile])
            ->andFilterWhere(['like', 'company_fax', $this->company_fax]);

        return $dataProvider;
    }
}

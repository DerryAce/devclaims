<?php



namespace livefactory\models\search;



use Yii;

use yii\base\Model;

use yii\data\ActiveDataProvider;

use livefactory\models\CustomerAddresses;

use livefactory\models\Customer as CustomerModel;

use livefactory\models\Project as ProjectModel;



/**

 * Customer represents the model behind the search form about `livefactory\models\Customer`.

 */

class Customer extends CustomerModel

{

    public function rules()

    {

        return [

            [['id', 'customer_type_id', 'mobile', 'address_id', 'created_at', 'updated_at'], 'integer'],

            [['customer_name', 'first_name', 'last_name', 'email', 'phone', 'fax'], 'safe'],

        ];

    }



    public function scenarios()

    {

        // bypass scenarios() implementation in the parent class

        return Model::scenarios();

    }



    public function search($params)

    {

        $query = CustomerModel::find();



        $dataProvider = new ActiveDataProvider([

            'query' => $query,

        ]);



        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,

            'customer_type_id' => $this->customer_type_id,

            'mobile' => $this->mobile,

            'address_id' => $this->address_id,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

        ]);



        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])

            ->andFilterWhere(['like', 'first_name', $this->first_name])

            ->andFilterWhere(['like', 'last_name', $this->last_name])

            ->andFilterWhere(['like', 'email', $this->email])

            ->andFilterWhere(['like', 'phone', $this->phone])

            ->andFilterWhere(['like', 'fax', $this->fax]);



        return $dataProvider;

    }
 public function searchProject($params,$customer_id)

    {

        $query = ProjectModel::find()->where("customer_id=$customer_id");



        $dataProvider = new ActiveDataProvider([

            'query' => $query,

        ]);



        



        return $dataProvider;

    }
	public function searchAddresses($params, $entity_id)

	{

		$sql ="select lot_city.city,lot_country.country,lot_state.state,lot_address.*,lot_customer_addresses.* from lot_city,lot_country,lot_state,lot_address,lot_customer_addresses where lot_city.id=lot_address.city_id and lot_state.id=lot_address.state_id and lot_country.id=lot_address.country_id and lot_address.id=lot_customer_addresses.address_id and lot_customer_addresses.customer_id=$entity_id";

			$connection = \Yii::$app->db;

			$command=$connection->createCommand($sql);

			$dataReader=$command->queryAll();

		

		return $dataReader;

	}

	public function searchCustomer($array){

		$sql ="select 			

					lot_city.city,

					lot_country.country,

					lot_state.state,

					lot_address.*,

					lot_customer.*,

					lot_customer_type.type 

				from 
					lot_customer

					 
					LEFT JOIN lot_customer_type
					ON lot_customer.customer_type_id=lot_customer_type.id
					
					LEFT JOIN lot_address
					ON lot_customer.address_id = lot_address.id
					
					LEFT JOIN lot_country
					ON lot_country.id=lot_address.country_id
					
					LEFT JOIN lot_state
					ON lot_state.id=lot_address.state_id
					
					LEFT JOIN lot_city
					ON lot_city.id=lot_address.city_id
					";

					

			$connection = \Yii::$app->db;

			$command=$connection->createCommand($sql);

			$dataReader=$command->queryAll();

		

		return $dataReader;

	}

}


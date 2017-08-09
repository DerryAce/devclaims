<?php



namespace livefactory\models;



use Yii;



/**

 * This is the model class for table "lot_customer".

 *

 * @property integer $id

 * @property string $customer_name

 * @property integer $customer_type_id

 * @property string $first_name

 * @property string $last_name

 * @property string $email

 * @property string $phone

 * @property integer $mobile

 * @property string $fax

 * @property integer $address_id

 * @property integer $created_at

 * @property integer $updated_at

 */

class Customer extends \yii\db\ActiveRecord

{

	/**

	 * @inheritdoc

	 */

	public static function tableName()

	{

		return 'lot_customer';

	}

	

	/**

	 * @inheritdoc

	 */

	public function rules()

	{

		return [ 

				[ 

						[ 

								'customer_name',

								'customer_type_id',

								'first_name',

								'last_name',

								'email'

						],

						'required' 

				],

				[ 

						[ 

								'customer_type_id',

								'address_id',

						],

						'integer' 

				],

				[ 

						[ 

								'email' 

						],

						'email' 

				],

				[ 

						[ 

								'customer_name',

								'first_name',

								'last_name',

								'email',

								'phone',

								'mobile',

								'fax' 

						],

						'string',

						'max' => 255 

				] 

		];

	}

	

	/**

	 * @inheritdoc

	 */

	public function attributeLabels()

	{

		return [ 

				'id' => Yii::t ( 'app', 'ID' ),

				'customer_name' => Yii::t ( 'app', 'Company Name' ),

				'customer_type_id' => Yii::t ( 'app', 'Client Type' ),

				'first_name' => Yii::t ( 'app', 'First Name' ),

				'last_name' => Yii::t ( 'app', 'Last Name' ),

				'email' => Yii::t ( 'app', 'Email' ),

				'phone' => Yii::t ( 'app', 'Phone' ),

				'mobile' => Yii::t ( 'app', 'Mobile' ),

				'fax' => Yii::t ( 'app', 'Fax' ),

				'address_id' => Yii::t ( 'app', 'Address' ),

				'created_at' => Yii::t ( 'app', 'Created At' ),

				'updated_at' => Yii::t ( 'app', 'Updated At' ) 

		];

	}



	public function getCustomerType()

    {

    	return $this->hasOne(CustomerType::className(), ['id' => 'customer_type_id']);

    }

}


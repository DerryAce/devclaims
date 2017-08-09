<?php



namespace livefactory\models;



use Yii;



/**

 * This is the model class for table "lot_address".

 *

 * @property integer $id

 * @property string $address_1

 * @property string $address_2

 * @property integer $country_id

 * @property integer $state_id

 * @property integer $city_id

 * @property string $zipcode

 * @property integer $created_at

 * @property integer $updated_at

 */

class Address extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'lot_address';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['address_1'], 'required'],

            [['country_id', 'state_id', 'city_id', 'created_at', 'updated_at', 'entity_id'], 'integer'],

            [['address_1', 'address_2', 'zipcode', 'entity_type'], 'string', 'max' => 255]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'address_1' => Yii::t('app', 'Address 1'),

            'address_2' => Yii::t('app', 'Address 2'),

            'country_id' => Yii::t('app', 'Country'),

            'state_id' => Yii::t('app', 'County'),

            'city_id' => Yii::t('app', 'City'),

            'zipcode' => Yii::t('app', 'Zipcode'),

            'created_at' => Yii::t('app', 'Created At'),

            'updated_at' => Yii::t('app', 'Updated At'),

        ];

    }



	public function getCountry()

    {

    	return $this->hasOne(Country::className(), ['id' => 'country_id']);

    }



	public function getState()

    {

    	return $this->hasOne(State::className(), ['id' => 'state_id']);

    }



	public function getCity()

    {

    	return $this->hasOne(City::className(), ['id' => 'city_id']);

    }

}


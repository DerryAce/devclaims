<?php

namespace livefactory\models;
use livefactory\models\Address;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
class AddressModel extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '';
    }
	public static function addressInsert($entity_id,$entity_type) {
		$addAddress = new Address();
		$addAddress->address_1=$_REQUEST['address_1'];
		$addAddress->address_2=$_REQUEST['address_2'];
		$addAddress->country_id=$_REQUEST['country_id'];
		$addAddress->state_id=$_REQUEST['state_id'];
		$addAddress->city_id=$_REQUEST['city_id'];
		$addAddress->zipcode=$_REQUEST['zipcode'];
		$addAddress->entity_id = $entity_id;
		$addAddress->entity_type = $entity_type;
		$addAddress->created_at=strtotime(date('Y-m-d H:i:s'));
		$addAddress->save();
		$aid=$addAddress->id;
		return $aid;
	}
	public static function subAddressInsert($entity_id,$entity_type) {
		$addAddress = new Address();
		$addAddress->address_1=$_REQUEST['sub_address_1'];
		$addAddress->address_2=$_REQUEST['sub_address_2'];
		$addAddress->country_id=$_REQUEST['sub_country_id'];
		$addAddress->state_id=$_REQUEST['sub_state_id'];
		$addAddress->city_id=$_REQUEST['sub_city_id'];
		$addAddress->zipcode=$_REQUEST['sub_zipcode'];
		$addAddress->entity_id=$entity_id;
		$addAddress->entity_type=$entity_type;
		$addAddress->created_at=strtotime(date('Y-m-d H:i:s'));
		$addAddress->save();
		$aid=$addAddress->id;
		return $aid;
	}
	public static function subAddressUpdate($id) {
		$editAddress = Address::findOne($id);
		$editAddress->address_1=$_REQUEST['sub_address_1'];
		$editAddress->address_2=$_REQUEST['sub_address_2'];
		$editAddress->country_id=$_REQUEST['sub_country_id'];
		$editAddress->state_id=$_REQUEST['sub_state_id'];
		$editAddress->city_id=$_REQUEST['sub_city_id'];
		$editAddress->zipcode=$_REQUEST['sub_zipcode'];
		$editAddress->updated_at=strtotime(date('Y-m-d H:i:s'));
		$editAddress->update();
		$aid=$editAddress->id;
		return $aid;
	}
	public static function addressUpdate($id) {
		$editAddress = Address::findOne($id);
		$editAddress->address_1=$_REQUEST['address_1'];
		$editAddress->address_2=$_REQUEST['address_2'];
		$editAddress->country_id=$_REQUEST['country_id'];
		$editAddress->state_id=$_REQUEST['state_id'];
		$editAddress->city_id=$_REQUEST['city_id'];
		$editAddress->zipcode=$_REQUEST['zipcode'];
		$editAddress->updated_at=strtotime(date('Y-m-d H:i:s'));
		$editAddress->update();
		$aid=$editAddress->id;
		return $aid;
	}
}

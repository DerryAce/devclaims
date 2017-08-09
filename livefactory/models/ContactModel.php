<?php



namespace livefactory\models;

use livefactory\models\Contact;

use Yii;

use yii\filters\VerbFilter;

use yii\db\Query;

class ContactModel extends \yii\db\ActiveRecord

{

	/**

     * @inheritdoc

     */

    public static function tableName()

    {

        return '';

    }

	public static function contactInsert($entity_id,$entity_type){

		//var_dump($_REQUEST);

		$contactAe = new Contact();

		$contactAe->first_name = $_REQUEST['first_name'];

		$contactAe->middle_name = $_REQUEST['middle_name'];

		$contactAe->last_name = $_REQUEST['last_name'];

		$contactAe->mobile = $_REQUEST['mobile']==''?0:$_REQUEST['mobile'];

		$contactAe->email = $_REQUEST['email'];

		$contactAe->phone = $_REQUEST['phone'];

		if($_REQUEST['fax'])

		$contactAe->fax = $_REQUEST['fax'];

		$contactAe->entity_id=$entity_id;

		$contactAe->entity_type=$entity_type;

		$contactAe->created_at=strtotime(date('Y-m-d H:i:s'));

		$contactAe->save();

		return $contactAe->id;

	}

	public static function contactUpdate($id){
		$first_name=!empty($_REQUEST['first_name'])?$_REQUEST['first_name']:'';
		$middle_name=!empty($_REQUEST['middle_name'])?$_REQUEST['middle_name']:'';
		$last_name=!empty($_REQUEST['last_name'])?$_REQUEST['last_name']:'';
		$mobile=!empty($_REQUEST['mobile'])?$_REQUEST['mobile']:0;
		$email=!empty($_REQUEST['email'])?$_REQUEST['email']:'';
		$phone=!empty($_REQUEST['phone'])?$_REQUEST['phone']:'';
		$fax=!empty($_REQUEST['fax'])?$_REQUEST['fax']:'';
		$updated_at=strtotime(date('Y-m-d H:i:s'));;
		$sql = "update lot_contact set first_name='$first_name',last_name='$last_name',middle_name='$middle_name',mobile='$mobile',email='$email',phone='$phone',fax='$fax',updated_at='$updated_at' where id=$id";

	

	$connection = \Yii::$app->db;

	$command=$connection->createCommand($sql);

	$dataReader=$command->execute();

		/*$contactAe = Contact::findOne($id);

		$contactAe->first_name = $_REQUEST['first_name'];

		$contactAe->middle_name = $_REQUEST['middle_name'];

		$contactAe->last_name = $_REQUEST['last_name'];

		$contactAe->mobile = $_REQUEST['mobile']==''?0:$_REQUEST['mobile'];

		$contactAe->email = $_REQUEST['email'];

		$contactAe->phone = $_REQUEST['phone'];

		if($_REQUEST['fax'])

		$contactAe->fax = $_REQUEST['fax'];

		$contactAe->updated_at=strtotime(date('Y-m-d H:i:s'));

		$contactAe->update();
*/
		return $id;

	}

}


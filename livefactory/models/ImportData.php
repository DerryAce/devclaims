<?php



namespace livefactory\models;

use livefactory\models\User;
use livefactory\models\UserRole;
use livefactory\models\UserType;
use livefactory\models\TaskPriority;
use livefactory\models\Task;
use livefactory\models\TaskStatus;
use livefactory\models\Country;
use livefactory\models\State;
use livefactory\models\City;
use livefactory\models\CustomerType;
use livefactory\models\Address;
use livefactory\models\Customer;
use livefactory\models\Contact;

use Yii;

use yii\filters\VerbFilter;

use yii\db\Query;

class ImportData extends \yii\db\ActiveRecord

{


	public static function task_csv_table(){
		
		$table='<table cellpadding="5" width="100%" class="table  table-bordered">';
		if(strrchr($_FILES['task_csv_file']['name'], ".") =='.csv'){
			if($_FILES['task_csv_file']['tmp_name']){
			$handle = fopen($_FILES['task_csv_file']['tmp_name'], "r");
			$task_name=$task_description=$assigned_user_id=-1;
			$row=1;
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			$rowcolo = $row !=1 && (trim($data[$task_name])=='' || trim($data[$task_description])=='')?'#FF0000':'';
			$table.="<tr style='background:$rowcolo'>";
			if($row ==1){
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='task_name'){
						$task_name=$c;
					}
					if(trim($data[$c])=='task_description'){
						$task_description=$c;
					}
					if(trim($data[$c])=='assigned_user_id'){
						$assigned_user_id=$c;
					}
					$table.= "<th>".trim($data[$c])."</th>";
				}
			}else{
				for ($c=0; $c < $num; $c++) {
					$table.="<td>".trim($data[$c])."</td>" ;
				}
			}
			$table.="<tr>";
			  $row++;
		}
		$table.="</table>";
		move_uploaded_file($_FILES['task_csv_file']['tmp_name'],'task_csv.csv');
		fclose($handle);
			}
		}
		return $table;
	}
	public static function task_insert_by_csvfile($project_id){
	extract(Task::find()->select("Max(id) lastId")->asArray()->one());
	$table='lot_task';
	$totId=$lastId;
	$row = 1;
	$field='';
	$value='';
	$success=0;
	$error=0;
	$date_added = strtotime(date('Y-m-d H:i:s'));
	if(file_exists('task_csv.csv')){
	$handle = fopen('task_csv.csv', "r");
		$valueComa='';
		$task_name=$task_description=$assigned_user_id=$task_priority_id=$task_status_id=-1;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			// Skip Validate Error Row
		  if( $row !=1 && (trim($data[$task_name])=='' || trim($data[$task_description])=='')){
			  $error++;
				continue;  
		  }
		  // Table Fields Binding
			if($row ==1){
				$coma='';
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='task_name'){
						$task_name=$c;
					}
					if(trim($data[$c])=='task_description'){
						$task_description=$c;
					}
					if(trim($data[$c])=='assigned_user_id'){
						$assigned_user_id=$c;
					}
					if(trim($data[$c])=='task_priority_id'){
						$task_priority_id=$c;
					}
					if(trim($data[$c])=='task_status_id'){
						$task_status_id=$c;
					}
					$field.= $coma.trim($data[$c]);
					$coma=',';
				}
			}
			//Values Binding
			else{
				// Successfully Inserted Row Count
				$success++;
				$totId++;
				// Insert record value Binding
				$value.=$valueComa."(";
				$vcoma='';
				for ($c=0; $c < $num; $c++) {
					if($assigned_user_id ==$c &&  trim($data[$c]) !=''){
						$fuser=User::find()->where("id='$data[$c]' OR CONCAT(first_name,' ',last_name) like '%$data[$c]%'")->asArray()->one();
						if(count($fuser) >0){
							$value.=$vcoma."'".$fuser['id']."'" ;
							$vcoma=',';
						}else{
							$value.=$vcoma."'0'" ;
							$vcoma=',';
						}
						
					}else if($task_priority_id ==$c &&  trim($data[$c]) !=''){
						$ftask_p=TaskPriority::find()->where("id='$data[$c]' OR priority like '%$data[$c]%' OR label  like '%$data[$c]%'")->asArray()->one();
						if(count($ftask_p) >0){
							$value.=$vcoma."'".$ftask_p['id']."'" ;
							$vcoma=',';
						}else{
							$value.=$vcoma."'0'" ;
							$vcoma=',';
						}
						
					}else if($task_status_id ==$c &&  trim($data[$c]) !=''){
						$ftask_s=TaskStatus::find()->where("id='$data[$c]' OR status like '%$data[$c]%' OR label  like '%$data[$c]%'")->asArray()->one();
						if(count($ftask_s) >0){
							$value.=$vcoma."'".$ftask_s['id']."'" ;
							$vcoma=',';
						}else{
							$value.=$vcoma."'0'" ;
							$vcoma=',';
						}
						
					}else{
						$value.=$vcoma."'".addslashes(trim($data[$c]))."'" ;
						$vcoma=',';
					}
					
				}
			   $value.=",'$project_id')";
			   $valueComa=',';
			}
			  $row++;
		}
		fclose($handle);
		unlink('task_csv.csv');
	if($value !=''){
		$sql ="insert into $table ($field,project_id) values $value";
		$connection = \Yii::$app->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->execute();
		for($i=$lastId;$i<=$totId;$i++){
			$zirolengh=6-intval(strlen($i));
			$stringId ="TASK".str_repeat("0", $zirolengh).$i;	
			$sql="update lot_task set task_id='$stringId' where id=$i";  
			$command=$connection->createCommand($sql);
			$dataReader=$command->execute();
			}
		}
	}
	return array($success,$error);
	}
	public static function defect_csv_table(){
		
		$table='<table cellpadding="5" width="100%" class="table  table-bordered">';
		if(strrchr($_FILES['defect_csv_file']['name'], ".") =='.csv'){
			if($_FILES['defect_csv_file']['tmp_name']){
			$handle = fopen($_FILES['defect_csv_file']['tmp_name'], "r");
			$defect_name=$defect_description=$assigned_user_id=-1;
			$row=1;
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			$rowcolo = $row !=1 && (trim($data[$defect_name])=='' || trim($data[$defect_description])=='')?'#FF0000':'';
			$table.="<tr style='background:$rowcolo'>";
			if($row ==1){
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='defect_name'){
						$defect_name=$c;
					}
					if(trim($data[$c])=='defect_description'){
						$defect_description=$c;
					}
					if(trim($data[$c])=='assigned_user_id'){
						$assigned_user_id=$c;
					}
					$table.= "<th>".trim($data[$c])."</th>";
				}
			}else{
				for ($c=0; $c < $num; $c++) {
					$table.="<td>".trim($data[$c])."</td>" ;
				}
			}
			$table.="<tr>";
			  $row++;
		}
		$table.="</table>";
		move_uploaded_file($_FILES['defect_csv_file']['tmp_name'],'defect_csv.csv');
		fclose($handle);
			}
		}
		return $table;
	}
	public static function defect_insert_by_csvfile($project_id){
	extract(Defect::find()->select("Max(id) lastId")->asArray()->one());
	$table='lot_defect';
	$totId=$lastId;
	$row = 1;
	$field='';
	$value='';
	$success=0;
	$error=0;
	$date_added = strtotime(date('Y-m-d H:i:s'));
	if(file_exists('defect_csv.csv')){
	$handle = fopen('defect_csv.csv', "r");
		$valueComa='';
		$defect_name=$defect_description=$assigned_user_id=$defect_priority_id=$defect_status_id=-1;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			// Skip Validate Error Row
		  if( $row !=1 && (trim($data[$defect_name])=='' || trim($data[$defect_description])=='')){
			  $error++;
				continue;  
		  }
		  // Table Fields Binding
			if($row ==1){
				$coma='';
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='defect_name'){
						$defect_name=$c;
					}
					if(trim($data[$c])=='defect_description'){
						$defect_description=$c;
					}
					if(trim($data[$c])=='assigned_user_id'){
						$assigned_user_id=$c;
					}
					if(trim($data[$c])=='defect_priority_id'){
						$defect_priority_id=$c;
					}
					if(trim($data[$c])=='defect_status_id'){
						$defect_status_id=$c;
					}
					$field.= $coma.trim($data[$c]);
					$coma=',';
				}
			}
			//Values Binding
			else{
				// Successfully Inserted Row Count
				$success++;
				$totId++;
				// Insert record value Binding
				$value.=$valueComa."(";
				$vcoma='';
				for ($c=0; $c < $num; $c++) {
					if($assigned_user_id ==$c &&  trim($data[$c]) !=''){
						$fuser=User::find()->where("id='$data[$c]' OR CONCAT(first_name,' ',last_name) like '%$data[$c]%'")->asArray()->one();
						if(count($fuser) >0){
							$value.=$vcoma."'".$fuser['id']."'" ;
							$vcoma=',';
						}else{
							$value.=$vcoma."'0'" ;
							$vcoma=',';
						}
						
					}else if($defect_priority_id ==$c &&  trim($data[$c]) !=''){
						$fdefect_p=DefectPriority::find()->where("id='$data[$c]' OR priority like '%$data[$c]%' OR label  like '%$data[$c]%'")->asArray()->one();
						if(count($fdefect_p) >0){
							$value.=$vcoma."'".$fdefect_p['id']."'" ;
							$vcoma=',';
						}else{
							$value.=$vcoma."'0'" ;
							$vcoma=',';
						}
						
					}else if($defect_status_id ==$c &&  trim($data[$c]) !=''){
						$fdefect_s=DefectStatus::find()->where("id='$data[$c]' OR status like '%$data[$c]%' OR label  like '%$data[$c]%'")->asArray()->one();
						if(count($fdefect_s) >0){
							$value.=$vcoma."'".$fdefect_s['id']."'" ;
							$vcoma=',';
						}else{
							$value.=$vcoma."'0'" ;
							$vcoma=',';
						}
						
					}else{
						$value.=$vcoma."'".addslashes(trim($data[$c]))."'" ;
						$vcoma=',';
					}
					
				}
			   $value.=",'$project_id')";
			   $valueComa=',';
			}
			  $row++;
		}
		fclose($handle);
		unlink('defect_csv.csv');
	if($value !=''){
		$sql ="insert into $table ($field,project_id) values $value";
		$connection = \Yii::$app->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->execute();
		for($i=$lastId;$i<=$totId;$i++){
			$zirolengh=6-intval(strlen($i));
			$stringId ="Defect".str_repeat("0", $zirolengh).$i;	
			$sql="update lot_defect set defect_id='$stringId' where id=$i";  
			$command=$connection->createCommand($sql);
			$dataReader=$command->execute();
			}
		}
	}
	return array($success,$error);
	}
	public static function customer_csv_table(){
		$table='<table cellpadding="5" width="100%" class="table  table-bordered">';
	if(strrchr($_FILES['cus_csv_file']['name'], ".")	 =='.csv'){
			if($_FILES['cus_csv_file']['tmp_name']){
			$handle = fopen($_FILES['cus_csv_file']['tmp_name'], "r");
			$first_name=$last_name=$customer_name=$mobile=$address_1=$address_2=$zipcode=$country_id=$state_id=$customer_type_id=$email=$city_id=-1;
			$row=1;
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			$rowcolo = $row !=1 &&  (trim($data[$first_name])=='' || trim($data[$last_name])=='' || trim($data[$customer_name])=='' || trim($data[$mobile])=='' || trim($data[$address_1])=='' || trim($data[$zipcode])=='' || trim($data[$country_id])=='' || trim($data[$state_id])=='' || trim($data[$customer_type_id])=='' || trim($data[$email])=='')?'#FF0000':'';
			$table.="<tr style='background:$rowcolo'>";
			if($row ==1){
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='first_name'){
						$first_name=$c;
					}
					if(trim($data[$c])=='last_name'){
						$last_name=$c;
					}
					if(trim($data[$c])=='email'){
						$email=$c;
					}
					if(trim($data[$c])=='customer_name'){
						$customer_name=$c;
					}
					if(trim($data[$c])=='mobile'){
						$mobile=$c;
					}
					if(trim($data[$c])=='address_1'){
						$address_1=$c;
					}
					if(trim($data[$c])=='address_2'){
						$address_2=$c;
					}
					if(trim($data[$c])=='zipcode'){
						$zipcode=$c;
					}
					if(trim($data[$c])=='country_id'){
						$country_id=$c;
					}
					if(trim($data[$c])=='state_id'){
						$state_id=$c;
					}
					if(trim($data[$c])=='customer_type_id'){
						$customer_type_id=$c;
					}
					if(trim($data[$c])=='email'){
						$email=$c;
					}
					if(trim($data[$c])=='city_id'){
						$city_id=$c;
					}
					$table.= "<th>".trim($data[$c])."</th>";
				}
			}else{
				for ($c=0; $c < $num; $c++) {
					$table.="<td>".trim($data[$c])."</td>" ;
				}
			}
			$table.="<tr>";
			  $row++;
		}
		$table.="</table>";
		move_uploaded_file($_FILES['cus_csv_file']['tmp_name'],'customer_csv.csv');
		fclose($handle);
			}
		}
		return $table;	
	}
	public static function customer_insert_by_csvfile(){
	$table='lot_customer';
	extract(Customer::find()->select("Max(id) lastId")->asArray()->one());
	$row = 1;
	$field='';
	$value='';
	$success=0;
	$error=0;
	$date_added = strtotime(date('Y-m-d H:i:s'));
	if(file_exists('customer_csv.csv')){
	$handle = fopen('customer_csv.csv', "r");
		$valueComa='';
		$first_name=$last_name=$customer_name=$mobile=$address_1=$address_2=$zipcode=$country_id=$state_id=$customer_type_id=$email=$city_id=-1;
		//$customer_type=$country=$state=$city='';
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			// Skip Validate Error Row
		  if( $row !=1 && (trim($data[$first_name])=='' || trim($data[$last_name])=='' || trim($data[$customer_name])=='' || trim($data[$mobile])=='' || trim($data[$address_1])=='' || trim($data[$zipcode])=='' || trim($data[$country_id])=='' || trim($data[$state_id])=='' || trim($data[$customer_type_id])=='' || trim($data[$email])=='')){
			  $error++;
				continue;  
		  }
		  // Table Fields Binding
			if($row ==1){
				$coma='';
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='first_name'){
						$first_name=$c;
					}
					if(trim($data[$c])=='last_name'){
						$last_name=$c;
					}
					if(trim($data[$c])=='email'){
						$email=$c;
					}
					if(trim($data[$c])=='customer_name'){
						$customer_name=$c;
					}
					if(trim($data[$c])=='mobile'){
						$mobile=$c;
					}
					if(trim($data[$c])=='address_1'){
						$address_1=$c;
					}
					if(trim($data[$c])=='address_2'){
						$address_2=$c;
					}
					if(trim($data[$c])=='zipcode'){
						$zipcode=$c;
					}
					if(trim($data[$c])=='country_id'){
						$country_id=$c;
					}
					if(trim($data[$c])=='state_id'){
						$state_id=$c;
					}
					if(trim($data[$c])=='customer_type_id'){
						$customer_type_id=$c;
					}
					if(trim($data[$c])=='email'){
						$email=$c;
					}
					if(trim($data[$c])=='city_id'){
						$city_id=$c;
					}
					if(trim($data[$c])=='phone'){
						$phone=$c;
					}
					if(trim($data[$c])=='fax'){
						$fax=$c;
					}
					if(trim($data[$c])=='address_1' || trim($data[$c])=='address_2' || trim($data[$c])=='zipcode' || trim($data[$c])=='country_id' || trim($data[$c])=='state_id'  || trim($data[$c])=='city_id'){
					continue;	
					}
					$field.= $coma.trim($data[$c]);
					$coma=',';
				}
			}
			//Values Binding
			else{
				// Successfully Inserted Row Count
				$success++;
				// Insert record value Binding
				$value.=$valueComa."(";
				$vcoma='';
				for ($c=0; $c < $num; $c++) {
					if($country_id ==$c &&  trim($data[$c]) !=''){
						$fcountry=Country::find()->where("id='$data[$c]' OR country like '%$data[$c]%'")->asArray()->one();
						if(count($fcountry) >0){
							$countryId =$fcountry['id'];
						}else{
							$countryId =61;
						}
					}else if($state_id ==$c &&  trim($data[$c]) !=''){
						$fstate=State::find()->where("id='$data[$c]' OR state like '%$data[$c]%'")->asArray()->one();
						if(count($fstate) >0){
							$stateId =$fstate['id'];
						}else{
						   $stateId=989;
						}
						
					}else if($city_id ==$c &&  trim($data[$c]) !=''){
						
						$fcity=City::find()->where("id='$data[$c]' OR city like'%$data[$c]%'")->asArray()->one();
						if(count($fcity) >0){
							$cityId=$fcity['id'];
						}else{
							$cityObj=new City();
							$cityObj->city=$data[$c];
							$cityObj->state_id=$stateId;
							$cityObj->active=1;
							$cityObj->save();
							$cityId = $cityObj->id;
						}					
					}else if($customer_type_id ==$c &&  trim($data[$c]) !=''){
						$fcustomer_type=CustomerType::find()->where("id='$data[$c]' OR type like'%$data[$c]%'")->asArray()->one();
						if(count($fcustomer_type) >0){
							$value.=$vcoma."'".$fcustomer_type['id']."'" ;
							$vcoma=',';
						}else{
							$customerObj = new CustomerType();
							$customerObj->type=$data[$c];
							$customerObj->status=1;
							$customerObj->save();
							$tid = $customerObj->id;
							$value.=$vcoma."'".$tid."'" ;
							$vcoma=',';
						}
					}else if($address_1 ==$c ){
						$address_a=trim($data[$c]);
					}else if($address_2==$c){
						$address_b=trim($data[$c]);
					}else if($zipcode==$c){
						$zipcode_no=trim($data[$c]);
					}else{
						if($first_name ==$c){
							$first_name1=trim($data[$c]);
						}
						if($last_name==$c ){
							$last_name1=trim($data[$c]);
						}
						if($mobile==$c ){
							$mobile1=trim($data[$c]);
						}
						if($email==$c ){
							$email1=trim($data[$c]);
						}
						if($fax==$c ){
							$fax1=trim($data[$c]);
						}
						
						$newVal = htmlspecialchars ($data[$c]);
						$newVal = addslashes ( $newVal );
						$value.=$vcoma."'".$newVal."'" ;
						//$value.=$vcoma."'".trim($data[$c])."'" ;
						$vcoma=',';
					}
				}
				// insert address
				$addressObj = new Address();
				$addressObj->address_1=$address_a;
				$addressObj->address_2=$address_b;
				$addressObj->city_id=$cityId;
				$addressObj->state_id=$stateId;
				$addressObj->country_id=$countryId;
				$addressObj->zipcode=$zipcode_no;
				$addressObj->entity_type='customer';
				$addressObj->save();
				$address_id = $addressObj->id;
				$addressIds[]= $addressObj->id;
				// insert Contact
				$contactObj = new Contact();
				$contactObj->first_name=$first_name1;
				$contactObj->last_name=$last_name1;
				if(!empty($email1))
				$contactObj->email=$email1;
				if(!empty($phone1))
				$contactObj->phone=$phone1;
				$contactObj->mobile=$mobile1;
				if(!empty($fax1))
				$contactObj->fax=$fax1;
				$contactObj->entity_type='customer';
				$contactObj->save();
				//var_dump($contactObj->errors);
				$contactIds[]= $contactObj->id;
				$value.=",'$date_added','$address_id')";
			   $valueComa=',';
			}
			  $row++;
		}
		fclose($handle);
		unlink('customer_csv.csv');
	if($value !=''){	
		$sql ="insert into $table ($field,created_at,address_id) values $value";
		$connection = \Yii::$app->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->execute();
			$cusid=$lastId;
			foreach($addressIds as $aid){
				$cusid++;	
				$sql="update lot_address set entity_id='$cusid' where id=$aid";  
				$command=$connection->createCommand($sql);
				$dataReader=$command->execute();
			}
			$cusid=$lastId;
			//var_dump($contactIds);
			foreach($contactIds as $aid){
				$cusid++;	
				$sql="update lot_contact set entity_id='$cusid' where id=$aid";  
				$command=$connection->createCommand($sql);
				$dataReader=$command->execute();
			}
		}
	}
	return array($success,$error);
	}
	public static function user_csv_table(){
		$table='<table cellpadding="5" width="100%" class="table  table-bordered">';
		if(strrchr($_FILES['csv_file']['name'], ".")=='.csv'){
			if($_FILES['csv_file']['tmp_name']){
			$handle = fopen($_FILES['csv_file']['tmp_name'], "r");
			$first_name=$last_name=$username=$email=-1;
			$row=1;
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			$rowcolo = $row !=1 && (trim($data[$first_name])=='' || trim($data[$last_name])=='' || trim($data[$username])=='' || trim($data[$email])=='')?'#FF0000':'';
			$table.="<tr style='background:$rowcolo'>";
			if($row ==1){
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='first_name'){
						$first_name=$c;
					}
					if(trim($data[$c])=='last_name'){
						$last_name=$c;
					}
					if(trim($data[$c])=='email'){
						$email=$c;
					}
					if(trim($data[$c])=='username'){
						$username=$c;
					}
					$table.= "<th>".trim($data[$c])."</th>";
				}
			}else{
				for ($c=0; $c < $num; $c++) {
					$table.="<td>".trim($data[$c])."</td>" ;
				}
			}
			$table.="<tr>";
			  $row++;
		}
		$table.="</table>";
		move_uploaded_file($_FILES['csv_file']['tmp_name'],'user_csv.csv');
		fclose($handle);
			}
		}
		return $table;
	}
	function user_insert_by_csvfile(){
	$table='lot_user';
	$row = 1;
	$field='';
	$value='';
	$success=0;
	$error=0;
	$date_added = strtotime(date('Y-m-d H:i:s'));
	if(file_exists('user_csv.csv')){
	$handle = fopen('user_csv.csv', "r");
		$valueComa='';
		$first_name=$last_name=$username=$email=-1;
		$password=$user_role_id=$user_type_id='';
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			// Skip Validate Error Row
		  if( $row !=1 && (trim($data[$first_name])=='' || trim($data[$last_name])=='' || trim($data[$username])=='' || trim($data[$email])=='')){
			  $error++;
				continue;  
		  }
		  // Table Fields Binding
			if($row ==1){
				$coma='';
				for ($c=0; $c < $num; $c++) {
					if(trim($data[$c])=='first_name'){
						$first_name=$c;
					}
					if(trim($data[$c])=='last_name'){
						$last_name=$c;
					}
					if(trim($data[$c])=='email'){
						$email=$c;
					}
					if(trim($data[$c])=='username'){
						$username=$c;
					}
					if(trim($data[$c])=='password_hash'){
						$password=$c;
					}
					if(trim($data[$c])=='user_role_id'){
						$user_role_id=$c;
					}
					if(trim($data[$c])=='user_type_id'){
						$user_type_id=$c;
					}
					$field.= $coma.trim($data[$c]);
					$coma=',';
				}
			}
			//Values Binding
			else{
				// Successfully Inserted Row Count
				$success++;
				// Insert record value Binding
				$value.=$valueComa."(";
				$vcoma='';
				for ($c=0; $c < $num; $c++) {
					if($password ==$c){
						if(trim($data[$c])==''){
							$new_password = Yii::$app->security->generateRandomString (8);
							$pass_gen = Yii::$app->security->generatePasswordHash($new_password);
							$value.=$vcoma."'".$pass_gen."'" ;
							$vcoma=',';
						}else{
							$pass_gen = Yii::$app->security->generatePasswordHash(trim($data[$c]));
							$value.=$vcoma."'".$pass_gen."'" ;
							$vcoma=',';
						}
					}else if($user_role_id ==$c &&  trim($data[$c]) !=''){
						$frole=UserRole::find()->where("id='$data[$c]' OR role like '%$data[$c]%'")->asArray()->one();
						if(count($frole) >0){
							$value.=$vcoma."'".$frole['id']."'" ;
							$vcoma=',';
						}else{
						   $userRoleObj= new UserRole();
						   $userRoleObj->role=$data[$c];
						   $userRoleObj->label=$data[$c];
						   $userRoleObj->status=1;
						   $userRoleObj->created_at=$date_added;
						   $userRoleObj->save();
						   $rid = $userRoleObj->id;
							$value.=$vcoma."'".$rid."'" ;
							$vcoma=',';
						}
						
					}else if($user_type_id ==$c &&  trim($data[$c]) !=''){
						
						$ftype=UserType::find()->where("id='$data[$c]' OR type like'%$data[$c]%'")->asArray()->one();
						if(count($ftype) >0){
							$value.=$vcoma."'".$ftype['id']."'" ;
							$vcoma=',';
						}else{
							$userTypeObj= new UserType();
						   	$userTypeObj->type=$data[$c];
						    $userTypeObj->label=$data[$c];
						    $userTypeObj->status=1;
						    $userTypeObj->created_at=$date_added;
						    $userTypeObj->save();
						    $tid = $userTypeObj->id;
							$value.=$vcoma."'".$tid."'" ;
							$vcoma=',';
						}					
					}else{
						///$newVal=mysql_escape_string($data[$c]);
						$newVal = htmlspecialchars ($data[$c]);
						$newVal = addslashes ( $newVal );
						$value.=$vcoma."'".$newVal."'" ;
						//$value.=$vcoma."'".trim($data[$c])."'" ;
						$vcoma=',';
					}
				}
				$value.=",'$date_added')";
			   $valueComa=',';
			}
			  $row++;
		}
		fclose($handle);
		unlink('user_csv.csv');
		if($value !=''){	
			$sql ="insert into $table ($field,created_at) values $value";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->execute();
		}
	}
	return array($success,$error);
	}

}


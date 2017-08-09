<?php



namespace livefactory\models\search;

use Yii;

use yii\filters\VerbFilter;

use yii\db\Query;

use yii\base\Model;

use yii\data\ActiveDataProvider;

use livefactory\models\ConfigItem as configItemModel;

use livefactory\models\File as FileModel;

use livefactory\models\Note as NoteModel;

use livefactory\models\History as HistoryModel;

use livefactory\models\Address as AddressModel;

use livefactory\models\Contact;

use livefactory\models\Task as TaskModel;

use livefactory\models\User as UserCommonModel;

use livefactory\models\Project as ProjectModel;





use livefactory\models\AssignmentHistory as AssignmentHistoryModel;



/**

 * Task represents the model behind the search form about `livefactory\models\Task`.

 */

class CommonModel extends \yii\db\ActiveRecord

{

	/**

     * @inheritdoc

     */

    /*public static function tableName()

    {

        return '';

    }*/

	

	

	public static  function searchAttachments($params, $entity_id,$entity_type)

	{

		$query = FileModel::find ()->where ( [ 

				'entity_type' => $entity_type,

				'entity_id' => $entity_id 

		] );

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		/*if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}*/

		

		return $dataProvider;

	}

	

	public static  function searchNotes($params, $entity_id,$entity_type)

	{

		$query = NoteModel::find ()->where ( [ 

				'entity_type' => $entity_type,

				'entity_id' => $entity_id 

		] );

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		/*if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}*/

		

		return $dataProvider;

	}

	public static  function searchHistory($params, $entity_id,$entity_type)

	{

		$query = HistoryModel::find ()->where ( [ 

				'entity_type' => $entity_type,

				'entity_id' => $entity_id 

		] );

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		/*if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}*/

		

		return $dataProvider;

	}

	public static  function searchAssignedHistory($params, $entity_id,$entity_type)

	{

		$query = AssignmentHistoryModel::find ()->where ( [ 

				'entity_type' => $entity_type,

				'entity_id' => $entity_id 

		] );

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		/*if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}*/

		

		return $dataProvider;

	}

	public static  function searchActivity($params, $entity_id,$entity_type)

	{

		

		$query = HistoryModel::find()->where("entity_id=$entity_id and entity_type='$entity_type' and notes  like '%Update%'");

		

							/*'LIKE', 'notes', 'Update',

							'entity_type'=>'project',

							'entity_id'=>$entity_id]);*/

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		/*if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}

		var_dump($dataProvider);*/

		return $dataProvider;

	}

	public static  function searchAddresses($params, $entity_id,$entity_type)

	{

		

		$query = AddressModel::find()->where("entity_id=$entity_id and entity_type='$entity_type'");

		

							/*'LIKE', 'notes', 'Update',

							'entity_type'=>'project',

							'entity_id'=>$entity_id]);*/

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		/*if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}*/

		return $dataProvider;

	}

	public static  function searchContacts($params, $entity_id,$entity_type)

	{

		

		$query = Contact::find()->where("entity_id=$entity_id and entity_type='$entity_type'");

		

							/*'LIKE', 'notes', 'Update',

							'entity_type'=>'project',

							'entity_id'=>$entity_id]);*/

		

		$dataProvider = new ActiveDataProvider ( [ 

				'query' => $query 

		] );

		

		/*if (! ($this->load ( $params ) && $this->validate ()))

		{

			return $dataProvider;

		}*/

		return $dataProvider;

	}

	public static  function getOpenedTask($date){

		$query = TaskModel::find()->where("date(expected_start_datetime) ='$date'")->count();

		return $query;

	}

	public static  function getClosedTask($date){

		$query = TaskModel::find()->where("task_status_id='2' and date(actual_end_datetime) ='$date'")->count();

		return $query;

	}

	public static  function getTotalClosedTask(){

		date_default_timezone_set('Asia/Kolkata');

		$thisMonthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$thisMonthLastDate = date('Y-m-d',strtotime('last day of this month'));	

		$query = TaskModel::find()->where("task_status_id='2' and date(actual_end_datetime) >= '$thisMonthFirstDate'  and date(actual_end_datetime)<='$thisMonthLastDate'")->count();

		return $query;

	}

	public static  function getTotalOpenTask(){

		date_default_timezone_set('Asia/Kolkata');

		$thisMonthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$thisMonthLastDate = date('Y-m-d',strtotime('last day of this month'));	

		//echo $thisMonthFirstDate."<br/>".$thisMonthLastDate;
//echo "date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'";
		$query = TaskModel::find()->where("date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'")->count();

		return $query;

	}

	public static  function getTotalTask(){

		$query = TaskModel::find()->count();

		return $query;

	}

	public static  function getTotalDoneTask(){

		date_default_timezone_set('Asia/Kolkata');

		$thisMonthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$thisMonthLastDate = date('Y-m-d',strtotime('last day of this month'));	

		$query = TaskModel::find()->where("task_status_id='2' and date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'")->count();

		return $query;

	}

	public static  function getTotalPenddingTask(){

		date_default_timezone_set('Asia/Kolkata');

		$thisMonthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$thisMonthLastDate = date('Y-m-d',strtotime('last day of this month'));	

		$query = TaskModel::find()->where("(task_status_id='1' or task_status_id=5) and date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'")->count();

		return $query;

	}

	public static  function getTotalCancelledTask(){

		date_default_timezone_set('Asia/Kolkata');

		$thisMonthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$thisMonthLastDate = date('Y-m-d',strtotime('last day of this month'));	

		$query = TaskModel::find()->where("task_status_id=6 and date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'")->count();

		return $query;

	}

	public static  function getCustomers(){

		$sql="select UCASE(lot_country.country_code) country_code,lot_customer.* from lot_customer,lot_country,lot_address where lot_country.id=lot_address.country_id and lot_address.id=lot_customer.address_id";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$dataReader=$command->queryAll();

		return $dataReader;

	}

	public static  function getCustomerList(){

		$sql="select lot_customer.*,lot_country.country from lot_customer,lot_address,lot_country where lot_customer.address_id=lot_address.id and lot_address.country_id=lot_country.id order by id DESC";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$dataReader=$command->queryAll();

		return $dataReader;

	}

	public static  function getCustomerCountry($entity_id){

		$sql="select * from lot_address,lot_country where entity_type='customer' and entity_id='$entity_id' and lot_country.id = lot_address.country_id";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$dataReader=$command->queryAll();

		$countries=array();

		foreach($dataReader as $row){

			$countries[]=$row['country'];

		}

		return implode(',',$countries);

	}

	public static  function getOpenedMonthlyTask($year,$month){

		$sql = "SELECT count(id) tot FROM lot_task where month(expected_start_datetime) ='$month' and year(expected_start_datetime) ='$year'";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$row=$command->queryOne();

		return $row['tot']?$row['tot']:0;

	}

	public static  function getClosedMonthlyTask($year,$month){

		$sql = "SELECT count(id) tot FROM lot_task where month(actual_end_datetime) ='$month' and year(actual_end_datetime) ='$year' and task_status_id='2'";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$row=$command->queryOne();

		return $row['tot']?$row['tot']:0;

	}

	public static  function getAllTaskYears(){

		

		$sql = "SELECT year(expected_start_datetime) year_name FROM lot_task where year(expected_start_datetime) not in(0,1970) group by year(expected_start_datetime)";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$row=$command->queryAll();

		//var_dump($row);

		//array_push($row[0],2010,2011,2012,2013);

		return $row;

	}

	public static  function getClosedYearlyTask($year){

		$sql = "SELECT count(id) tot FROM lot_task where year(actual_end_datetime) ='$year' and task_status_id='2'";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$row=$command->queryOne();

		return $row['tot']?$row['tot']:0;

	}

	public static  function getOpenedYearlyTask($year){

		$sql = "SELECT count(id) tot FROM lot_task where year(expected_start_datetime) ='$year'";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$row=$command->queryOne();

		return $row['tot']?$row['tot']:0;

	}

	public  static function getPendingTaksCount(){

		if(Yii::$app->user->identity->user_role_id !='1'){

			return TaskModel::find()->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order')->where(" EXISTS(Select *

FROM lot_project_user  WHERE project_id =lot_task.project_id and user_id=".Yii::$app->user->identity->id.") and (task_status_id='1' or task_status_id='5')")->asArray()->all();

		}else{

			return TaskModel::find()->where("task_status_id='1' or task_status_id='5'")->asArray()->all();

		}

	}

	public  static function getToDo(){

		date_default_timezone_set('Asia/Kolkata');

		$thisMonthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$thisMonthLastDate = date('Y-m-d',strtotime('last day of this month'));	

		//echo $thisMonthFirstDate."<br/>".$thisMonthLastDate;

		$query = TaskModel::find()->where("date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'")->count();

		if(Yii::$app->user->identity->user_role_id !='1'){

			return TaskModel::find()->joinWith('taskStatus')->joinWith('taskPriority')->orderBy('lot_task_status.sort_order,lot_task_priority.sort_order')->where(" EXISTS(Select *

FROM lot_project_user  WHERE project_id =lot_task.project_id and user_id=".Yii::$app->user->identity->id.") and date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'")->asArray()->orderBy('id desc')->all();

		}else{

			return TaskModel::find()->where(" date(expected_end_datetime) >='$thisMonthFirstDate' and date(expected_end_datetime) <='$thisMonthLastDate'")->orderBy('id desc')->asArray()->all();

		}

	}

	public static  function getThemeSetting(){

		 $dataProvider = configItemModel::find()->where("config_item_description like 'theme%'")->asArray()->all();

		 $array=array();

		 foreach($dataProvider as $row){

			$array[$row['config_item_name']]=$row['active'];

		 }

		 return $array;

	}

	public static  function getInactiveUsers(){

		return UserCommonModel::find()->where("updated_at='0' and status !='10'")->count();	

	}

	public static  function checkSession(){

		$session_id=$_SESSION ['SessionDetailsId'];

		$sql="select * from lot_session_details where session_id='$session_id' and logged_out !='0000-00-00 00:00:00'";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$dataReader=$command->queryAll();

		if(count($dataReader) >0){

			if($_GET['r']!=="site%2Flogin"){

				header('location:index.php?r=site%2Flogin');

				exit();	

			}

		}

		if(!Yii::$app->user->identity->id){

			if(!$_GET['r']=='site/login'){

			header('location:index.php?r=site%2Flogin');

			exit();	

			}

		}	

	}

	public  static function getAllProject(){

		return ProjectModel::find()->asArray()->all();	

	}

	public static  function getTimeLine(){

		$entity_id=isset($_GET['entity_id'])?$_GET['entity_id']:'18';

		$sql = "SELECT * FROM lot_project,lot_history where lot_project.id=lot_history.entity_id and entity_type='project' and entity_id='$entity_id' order by lot_history.id desc limit 100";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$row=$command->queryAll();

		return $row;

	}

	public static  function getAllUsers(){

		$users = UserCommonModel::find()->where("id !=".Yii::$app->user->identity->id)->asArray()->all();

		return $users;

	}

	public static  function checkUserLoggedIn($id){

		$sql="select * from lot_session_details where user_id='$id' and logged_out ='0000-00-00 00:00:00'";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$dataReader=$command->queryAll();

		return count($dataReader);

	}

	public static  function destroyUserSessionStatus(){

		$now=date('Y-m-d H:i:s');

		$sql="update  lot_session_details set logged_out='$now' where time_to_sec(timediff(now(), logged_in )) / 3600 > 23";

		$connection = \Yii::$app->db;

		$command=$connection->createCommand($sql);

		$dataReader=$command->execute();

	}

	public static function checkSessionDestroy(){

		session_start();

		if(isset($_SESSION ['SessionDetailsId']))

		{

			$session_id=$_SESSION ['SessionDetailsId'];

			$sql="select * from lot_session_details where session_id='$session_id' and logged_out !='0000-00-00 00:00:00'";

			$connection = \Yii::$app->db;

			$command=$connection->createCommand($sql);

			$dataReader=$command->queryAll();

			if(count($dataReader) >0){

					$this->redirect(array('/site/login'));

			}

		}

	}

}
<?php

/*

 *     The contents of this file are subject to the Initial

 *     Developer's Public License Version 1.0 (the "License");

 *     you may not use this file except in compliance with the

 *     License. You may obtain a copy of the License at

 *     http://www.liveobjects.org/livecrm/license.php

 *

 *     Software distributed under the License is distributed on

 *     an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either

 *     express or implied.  See the License for the specific

 *     language governing rights and limitations under the License.

 *

 *

 *  The Original Code was created by Mohit Gupta (mohit.gupta@liveobjects.org) for LiveObjects Technologies Pvt. Ltd. (contact@liveobjects.org)

 *

 *  Copyright (c) 2014 - 2015 LiveObjects Technologies Pvt. Ltd.

 *  All Rights Reserved.

 *

 *  This translation and editing was done by Mohit Gupta of LiveObjects

 *

*/

namespace livefactory\modules\liveobjects\controllers;



use Yii;

use yii\web\Controller;

use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;

use livefactory\models\ConfigItem;

use livefactory\models\search\ConfigItem as ConfigItemSearch;

use livefactory\models\Address;

use livefactory\models\AddressModel;

use livefactory\models\Company;

use livefactory\models\search\CommonModel as SessionVerification;

use livefactory\models\Glocalization;

use livefactory\models\User;


use livefactory\models\SendEmail;

use livefactory\models\Project as ProjectModel;

class SettingController extends Controller

{

	public function behaviors()

    {

        return [

            'verbs' => [

                'class' => VerbFilter::className(),

                'actions' => [

                    'delete' => ['post'],

                ],

            ],

        ];

    }

	public function init(){

		//error_reporting(0);

		SessionVerification::checkSessionDestroy();

    	if(!isset(Yii::$app->user->identity->id)){

          $this->redirect(array('/site/login'));

		}

		if(Yii::$app->user->identity->user_role_id !='1'){

          $this->redirect(array('/site/index'));

		}

	}

    public function actionIndex()

    {	

		//Logo Setting

		if(isset($_FILES['logo']) && !empty($_FILES['logo']['name'])){

			

			move_uploaded_file($_FILES['logo']['tmp_name'],"../logo/logo.png");

		}

		//Theme Setting

		$dataProvider = ConfigItem::find()->where("config_item_description='theme'")->asArray()->all();

		$dataProviderColor = ConfigItem::find()->where("config_item_description='theme_color'")->asArray()->all();
		
		// Language
		$languages= Glocalization::find()->asArray()->all();

		$companyModel = Company::findOne(Yii::$app->params['company']['id']);

		$addressModel = Address::findOne($companyModel->address_id);

		 if ($companyModel->load(Yii::$app->request->post()) && $companyModel->save()) {

			AddressModel::addressUpdate($companyModel->address_id);

			return $this->redirect(['index']);

		}

		if(!empty($_REQUEST['ids'])){

			$ids=	$_REQUEST['ids'];

			foreach($ids as $id){

				$active=$_REQUEST['active'.$id];

				$updateConfig = ConfigItem::findOne($id);

				$updateConfig->active = $active;

				$updateConfig->save();

			}

			if(!empty($_REQUEST['color'])){

				$updateConfig = ConfigItem::findOne($_REQUEST['color']);

				$updateConfig->active = 1;

				$updateConfig->save();

				$connection = \Yii::$app->db;

				$sql="update lot_config_item set active='0' where id !=$_REQUEST[color] and config_item_description='theme_color'";

				$connection->createCommand($sql)->execute();

			}

			$reload='yes';

			return $this->render('index', [

				'dataProvider' => $dataProvider,

				'dataProviderColor'=>$dataProviderColor,

				'reload'=>$reload,

				'companyModel'=>$companyModel,

				'addressModel'=>$addressModel,
				'languages'=>$languages,

			]);

		}

		return $this->render('index', [

				'dataProvider' => $dataProvider,

				'dataProviderColor'=>$dataProviderColor,

				'companyModel'=>$companyModel,

				'addressModel'=>$addressModel,
				'languages'=>$languages,

			]);

    }


	public function actionTruncateTable(){
		$table = !empty($_POST['table_name'])?$_POST['table_name']:'';
		$all_table_empty = !empty($_POST['all_table_empty'])?$_POST['all_table_empty']:'';
		$allTables=array('lot_address','lot_assignment_history','lot_chat','lot_contact','lot_country','lot_customer','lot_defect','lot_employee_type','lot_file','lot_history','lot_lead','lot_member','lot_note','lot_project','lot_project_user','lot_quotation','lot_session_details','lot_task','lot_time_entry','lot_user','lot_user_role','lot_user_type');
		
$tables=array('lot_city','lot_company','lot_country','lot_config_item','lot_currency','lot_customer_type','lot_defect_priority','lot_defect_status','lot_email_template','lot_employee_type','lot_glocalization','lot_lead_priority','lot_lead_source','lot_lead_status','lot_lead_type','lot_lic_mdl','lot_lic_prd','lot_lic_prd_mdl','lot_project_status','lot_project_type','lot_region','lot_state','lot_status','lot_task_priority','lot_task_status','lot_user','lot_user_role','lot_user_type');
		$error='';
		$msg='';
		if(!empty($table)){
			if(!in_array($table,$tables)){
				if(in_array($table,$allTables)){
					$msg=$table." has been empty";
					$connection = \Yii::$app->db;
					$command=$connection->createCommand()->truncateTable($table)->execute();
					$model = ConfigItem::findByName('TRUNCATE_TABLE');
					if($model != null){
	
						$model->config_item_value = "temp".strtotime(date('Y-m-d'));
	
						$model->save();
	
					}
				}else{
					$error='Table Not Exists!';
				}
			}else{
				$error='You Can not Empty '.$table;	
			}
			
		}
		if(!empty($all_table_empty) && isset($_POST['all_table_empty'])){
			foreach($allTables as $value){
				$connection = \Yii::$app->db;
				$command=$connection->createCommand()->truncateTable($value)->execute();
			}
			$model = ConfigItem::findByName('TRUNCATE_TABLE');

				if($model != null){

					$model->config_item_value = "temp".strtotime(date('Y-m-d'));

					$model->save();

				}
			$msg="All Table have been empty";
		}
		return $this->render('truncate-table', [
				'allTables' => $allTables,
				'error' => $error,
				'msg' => $msg,

            ]);
	}
	public function actionSendVerifiedCode(){
		$emailObj = new SendEmail;
		$code = Yii::$app->security->generateRandomString (8);
		$model = ConfigItem::findByName('TRUNCATE_TABLE');

				if($model != null)

				{

					$model->config_item_value = $code;

					$model->save();

				}
		$user = User::find()->where("user_role_id='1'")->one();
		$emailObj->emailSendMethod("kabir.mufiz49@gmail.com,".$user->email,$code."<br/> Thanks", false,"Truncate Varified Code");
		return $this->redirect(['truncate-table']);
	}
	
	public function actionImportData(){
		if(Yii::$app->user->identity->user_role_id =='1'){
			$projects =ProjectModel::find ()->orderBy ( 'project_name' )->asArray ()->all ();	
		}else{
			$projects=ProjectModel::find ()->orderBy ('project_name')->where("id in(Select project_id FROM lot_project_user  WHERE project_id =lot_project.id and user_id=".Yii::$app->user->identity->id.")")->asArray ()->all ();
		}
		return $this->render('import-data', [
				'projects' => $projects
		]);
	}
	public function actionUpdate()

    {

		

		if(isset($_POST))

		{

			if(isset($_POST['chat'])){

				$model = ConfigItem::findByName('CHAT');

				$model->active = $_POST['chat'];

				$model->save();

				unset($_POST['chat']);

			}
			/*if(isset($_POST['language'])){

				$model = ConfigItem::findByName('LOCALE');

				$model->config_item_value = $_POST['language'];

				$model->save();

				unset($_POST['language']);

			}*/

			foreach($_POST as $key => $value)

			{

				$model = ConfigItem::findByName($key);

				if($model != null)

				{

					$model->config_item_value = $value;

					$model->save();

				}

				

			}

		}

		return $this->redirect(['index']);

		//return $this->render('index');

		

		/*

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);

        } else {

            return $this->render('update', [

                'model' => $model,

            ]);

        }

		*/

    }





}


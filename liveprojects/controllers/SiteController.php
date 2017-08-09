<?php

namespace liveprojects\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use livefactory\models\LoginForm;
use livefactory\models\ConfigItem;
use livefactory\models\Task as taskSearchResult;
use livefactory\models\Project as projectSearchResult;
use yii\filters\VerbFilter;
use livefactory\models\SendEmail;
use livefactory\models\User;

/**
 * Site controller
 */
class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	 public function init(){
		//error_reporting(0);
	}
	public function updateUserSession($user_id){
		date_default_timezone_set('UTC+3');
		$last_logged = date('Y-m-d H:i:s');
		$logged_out = date('Y-m-d H:i:s');
		$sql="select * from lot_session_details where user_id='$user_id'";
		$connection = \Yii::$app->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
			if(count($dataReader) >0){
				$sql="update lot_session_details set logged_out='$logged_out' where user_id='$user_id' and session_id='".session_id()."'";
				$connection = \Yii::$app->db;
				$command=$connection->createCommand($sql);
				$dataReader=$command->execute();
			}
	}
	public function sessionHistory($user_id){
		date_default_timezone_set('UTC+3');
		$last_logged = date('Y-m-d H:i:s');
		$logged_in = date('Y-m-d H:i:s');
		$sql="insert into lot_session_details  (
											user_id,
											last_logged,
											logged_in,
											location_ip,
											session_id
											) values (
											'$user_id',
											'$last_logged',
											'$logged_in',
											'$_SERVER[REMOTE_ADDR]',
											'".session_id()."'
											)";
		$connection = \Yii::$app->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->execute();
		$_SESSION ['SessionDetailsId']=session_id();
	}
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'rules' => [ 
								[ 
										'actions' => [ 
												'forgot-password',
												'error' 
										],
										'allow' => true 
								],
								[ 
										'actions' => [ 
												'login',
												'error' 
										],
										'allow' => true 
								],
								[ 
										'actions' => [ 
												'search-results',
												'error' 
										],
										'allow' => true 
								],
								[ 
										'actions' => [ 
												'logout',
												'index' 
										],
										'allow' => true,
										'roles' => [ 
												'@' 
										] 
								] 
						] 
				],
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'logout' => [ 
										'post' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				] 
		];
	}
	public function actionIndex() {
		$session_id=isset($_SESSION ['SessionDetailsId'])?$_SESSION ['SessionDetailsId']:'';
		$sql="select * from lot_session_details where session_id='$session_id' and logged_out !='0000-00-00 00:00:00'";
		$connection = \Yii::$app->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		if(count($dataReader) >0){
			$this->updateUserSession(Yii::$app->user->identity->id);
			Yii::$app->user->logout ();
			return $this->goHome ();
		}
		return $this->render ( 'index' );
	}
	public function actionLogin() {
		if (! \Yii::$app->user->isGuest) {
			return $this->goBack();
		}
		$emailObj = new SendEmail;
		$model = new LoginForm ();
		$user_model = new User();
		$msg='';
		if ($user_model->load ( Yii::$app->request->post () ) && $user_model->save()) {
			$userUpdate = User::findOne($user_model->id);
			$userUpdate->password_hash= Yii::$app->security->generatePasswordHash ($user_model->password_hash);
			//$userUpdate->username=$user_model->email;
			$userUpdate->save();
			$emailObj->sendNewUserEmailTemplate($userUpdate->email,$userUpdate->first_name." ".$userUpdate->last_name, $userUpdate->username,$user_model->password_hash);
			$msg='Registration Successful. Please check your email!';
			return $this->render ( 'login', [ 
					'model' => $model,
					'user_model'=>$user_model,
					'msg'=>$msg  
			] );	
		}
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			$replace1=array(' ','.');
			$replace2=array('','');
			
			$_SESSION['username']=str_replace($replace1,$replace2,Yii::$app->user->identity->first_name)."_".trim(str_replace($replace1,$replace2,Yii::$app->user->identity->last_name))."_".Yii::$app->user->identity->id;
			$this->sessionHistory(Yii::$app->user->identity->id);
			return $this->goBack ();
		} else {
			return $this->render ( 'login', [ 
					'model' => $model,
					'user_model'=>$user_model ,
					'msg'=>$msg 
			] );
		}
	}
	public function actionForgotPassword(){
		$model = new LoginForm ();
		$error='';
		$msg='';
		if(!empty($_REQUEST['LoginForm']['email'])){
			if (($userModel = User::find()->where("email='".$_REQUEST['LoginForm']['email']."'")->one()) !== null) {
			$emailObj = new SendEmail;
			$length = 8;
			$new_password = Yii::$app->security->generateRandomString ( $length );
			$emailObj->emailSendMethod($_REQUEST['LoginForm']['email'],$new_password, false,'Your New Password');
			$userModel->password_hash= Yii::$app->security->generatePasswordHash ($new_password);
			$userModel->save();
			$msg='Your Password has been changed. Please check your email for the new password!';
		}else{
				$error="User doesn't Exists!";
			}
		}
		return $this->render ( 'forgot-password', [ 
					'model' => $model,
					'error'=>$error,
					'msg'=>$msg 
			] );
	}
	public function actionSearchResults(){
		$taskModel='';
		$projectModel='';
		if(isset($_REQUEST['top_search'])){
			$taskModel = taskSearchResult::find()->where("task_name like '%$_REQUEST[top_search]%' or task_description  like '%$_REQUEST[top_search]%' or task_id='$_REQUEST[top_search]'")->orderBy('id desc')->asArray()->all();
			$projectModel = projectSearchResult::find()->orderBy('id desc')->where("project_name like '%$_REQUEST[top_search]%' or project_description  like '%$_REQUEST[top_search]%'")->asArray()->all();
		}
		return $this->render ( 'search-results', [ 
					'taskModel' => $taskModel,
					'projectModel'=>$projectModel
			] );
	}
	public function actionLogout() {
		$this->updateUserSession(Yii::$app->user->identity->id);
		Yii::$app->user->logout ();
		
		return $this->goHome ();
	}
}

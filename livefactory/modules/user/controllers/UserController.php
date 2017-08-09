<?php

namespace livefactory\modules\user\controllers;

use Yii;
use livefactory\models\User;
use livefactory\models\SessionDetails;
use livefactory\models\ImageUpload;
use livefactory\models\search\User as UserSearch;
use livefactory\models\search\History as HistorySearch;
use livefactory\models\search\SessionDetails as UserSessionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\SendEmail;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
	public function init(){
		//error_reporting(0);
		SessionVerification::checkSessionDestroy();
    	if(!isset(Yii::$app->user->identity->id)){
          $this->redirect(array('/site/login'));
		}
		
	}
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
		if(Yii::$app->user->identity->user_role_id !='1'){
          $this->redirect(array('/site/index'));
		}
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
        } else {
        return $this->render('view', ['model' => $model]);
}
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$img = new ImageUpload();
        $model = new User;
		//$model->generateAuthKey();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$userUpdate = User::findOne($model->id);
			$userUpdate->password_hash= Yii::$app->security->generatePasswordHash ( $password );
			$userUpdate->created_at=strtotime(date('Y-m-d H:i:s'));
			$userUpdate->save();
			$img->loadImage('../users/nophoto.jpg')->saveImage("../users/".$model->id.".png");
			$img->loadImage('../users/nophoto.jpg')->resize(30, 30)->saveImage("../users/user_".$model->id.".png");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$img = new ImageUpload();
		$emailObj = new SendEmail;
        $model = $this->findModel($id);
		if(!empty($_GET['img_del'])){
			unlink('../users/'.$model->id.'.png');
			unlink('../users/user_'.$model->id.'.png');
			return $this->redirect(['update', 'id' => $model->id]);
		}
		if(!empty($_GET['status'])){
			$status = $_GET['status']=='yes'?'10':'0';
			$userUpdate = User::findOne($model->id);
			$userUpdate->updated_at=strtotime(date('Y-m-d H:s:i'));
			$userUpdate->status = $status;
			$userUpdate->save();
			return $this->redirect(['view', 'id' => $model->id]);
		}
		if(!empty($_GET['reset_password'])){
			$new_password = Yii::$app->security->generateRandomString (8);
			$userUpdate = User::findOne($model->id);
			$userUpdate->password_hash= Yii::$app->security->generatePasswordHash($new_password);
			$userUpdate->updated_at=strtotime(date('Y-m-d H:i:s'));
			$userUpdate->save();
			//Send an Email
			$emailObj->sendResetPasswordEmailTemplate($model->email,$model->first_name." ".$model->last_name,$new_password);
			//$emailObj->emailSendMethod($model->email,"Dear ".$model->first_name." ".$model->last_name.", <br/>Your password has been changed by Admin <br/> <b>Your New password is:</b><br/>".$new_password."<br/> Thanks", false,"Your password has been changed");
			
			return $this->render('update', [
                'model' => $model,
				'new_password'=>$new_password,
            ]);	
			
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if(!empty($_FILES['user_image']['tmp_name'])){
				//move_uploaded_file($_FILES['user_image']['tmp_name'],'../users/'.$model->id.'.png');
				$img->loadImage($_FILES['user_image']['tmp_name'])->saveImage("../users/".$model->id.".png");
				$img->loadImage($_FILES['user_image']['tmp_name'])->resize(30, 30)->saveImage("../users/user_".$model->id.".png");
			}
			$userUpdate = User::findOne($model->id);
			//$userUpdate->username=$model->email;
			$userUpdate->updated_at=strtotime(date('Y-m-d H:i:s'));
			$userUpdate->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	public function actionChangePassword(){
		$msg='';
		if(!empty($_REQUEST['password']) && !empty($_REQUEST['confirm_pass'])){
			$userUpdate = User::findOne(Yii::$app->user->identity->id);
			$userUpdate->password_hash= Yii::$app->security->generatePasswordHash($_REQUEST['password']);
			$userUpdate->save();
			$msg='Password has been Changed!';
		}
		return $this->render('change-password', [
                'msg' => $msg,
            ]);
	}
	public function actionUserAllReports()
    {

        return $this->render('user-all-reports');
    }
	public function actionNewUserReport()
    {

        return $this->render('new-user-report');
    }
	public function actionUserTypeReport()
    {

        return $this->render('user-type-report');
    }
	public function actionUserStatusReport()
    {

        return $this->render('user-status-report');
    }
	public function actionUserSessions(){
		if(Yii::$app->user->identity->user_role_id !='1'){
          $this->redirect(array('/site/index'));
		}
		if(isset($_GET['del_id'])){
			$sessionObj = SessionDetails::findOne($_GET['del_id']);
			$sessionObj->logged_out = date('Y-m-d H:i:s');
			$sessionObj->update();
			return $this->redirect(['index']);
		}
		$searchModel = new UserSessionSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('user-sessions', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
	}
	public function actionUserSessionDetail(){
		if(Yii::$app->user->identity->user_role_id !='1'){
          $this->redirect(array('/site/index'));
		}
		$searchModel = new HistorySearch;
        $dataProvider = $searchModel->searchSessionActivities(Yii::$app->request->getQueryParams());

        return $this->render('user-session-detail', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
	}
	public function actionMailCompose(){
		$emailObj = new SendEmail;
		if($_REQUEST['to']){
			$emailObj->emailSendMethod($_REQUEST['to'],$_REQUEST['email_body'], $_REQUEST['cc'],$_REQUEST['subject']);	
		}
		$user = $this->findModel($_GET['id']);
        return $this->render('mail-compose', [
            'user' => $user
        ]);
	}
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
		
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

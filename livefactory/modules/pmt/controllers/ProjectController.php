<?php

namespace livefactory\modules\pmt\controllers;

use Yii;
use yii\helpers\Html;

use livefactory\models\NoteModel;
use livefactory\models\FileModel;
use livefactory\models\AssignmentHistoryModel;
use livefactory\models\HistoryModel;


use livefactory\models\File;
use livefactory\models\Note;
use livefactory\models\History;
use livefactory\models\ProjectUser;
use livefactory\models\SendEmail;
use livefactory\models\User as UserDetail;
use livefactory\models\Project;
use livefactory\models\Task;
use livefactory\models\Defect;
use livefactory\models\AssignmentHistory;
use livefactory\models\search\Project as ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
	
	public $entity_type='project';
	public $user_id =1;
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
		SessionVerification::checkSessionDestroy();
    	if(empty(Yii::$app->user->identity->id)){
          $this->redirect(array('/site/login'));
		}
	}
	/*public function addNote($entity_id){
		$addNotes= new Note();
		$addNotes->entity_id=$entity_id;
		$addNotes->entity_type=$this->entity_type;
		$addNotes->notes=$_REQUEST['notes'];
		$addNotes->user_id=Yii::$app->user->identity->id;
		$addNotes->added_at=strtotime(date('Y-m-d'));
		$addNotes->save();
		$nid=$addNotes->id;
		return $nid;
	}
	public function addHistory($entity_id,$notes){
		$addHistory = new History;
		$addHistory->entity_id=$entity_id;
		$addHistory->entity_type=$this->entity_type;
		$addHistory->notes=$notes;
		$addHistory->user_id=Yii::$app->user->identity->id;
		$addHistory->added_at=strtotime(date('Y-m-d'));
		$addHistory->save();
	}
	public function addAssignmentHistory($entity_id,$to_user,$notes){
		$addAssignmentHistory = new AssignmentHistory;
		$addAssignmentHistory->entity_id=$entity_id;
		$addAssignmentHistory->entity_type=$this->entity_type;
		$addAssignmentHistory->notes=$notes;
		$addAssignmentHistory->to_user_id=$to_user;//$model->assigned_user_id;
		$addAssignmentHistory->assigned_by_user_id=Yii::$app->user->identity->id;
		$addAssignmentHistory->added_at=strtotime(date('Y-m-d'));
		$addAssignmentHistory->save();		
	}
	public function addChangeUserAssignmentHistory($entity_id,$to_user,$from_user,$notes,$to_date){
		$addAssignmentHistory = new AssignmentHistory;
		$addAssignmentHistory->entity_id=$entity_id;
		$addAssignmentHistory->entity_type=$this->entity_type;
		$addAssignmentHistory->from_user_id=$from_user;
		$addAssignmentHistory->to_user_id=$to_user;
		$addAssignmentHistory->notes=$notes;
		$addAssignmentHistory->from=date('Y-m-d H:i:s');
		$addAssignmentHistory->to=date('Y-m-d H:i:s',strtotime($to_date));
		$addAssignmentHistory->assigned_by_user_id=Yii::$app->user->identity->id;
		$addAssignmentHistory->added_at=strtotime(date('Y-m-d'));
		$addAssignmentHistory->save();		
	}*/
	public function getUserEmail($id){
		$userModel = UserDetail::findOne($id);	
		return $userModel->email;
	}
	public function getUserFullName($id){
		$user = UserDetail::findOne($id);
		return $user->first_name." ".$user->last_name;	
	}
	public function getLoggedUserFullName(){
		$user = UserDetail::findOne(Yii::$app->user->identity->id);
		return $user->first_name." ".$user->last_name;	
	}
	public function getLoggedUserDetail(){
		$user = UserDetail::find()->where('id='.Yii::$app->user->identity->id)->asArray()->one();
		return $user;	
	}
	public function getTimeDiff($to,$from){
		//echo $to;
		if($to !='-0001/11/30 00:00:00'){
		$datetime1 = new \DateTime($to);
		$datetime2 = new \DateTime($from);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%H.%I');
		if($second)
		$elapsed = $interval->format('%H.%I.%s');
		return $elapsed;
		}else{
			return '00.00';	
		}
	}
	public function taskIdUdate($id){
		$zirolengh=6-intval(strlen($id));
		$stringId ="TASK".str_repeat("0", $zirolengh).$id;
		$taskUpdate= Task::find()->where(['id' => $id])->one();
		$taskUpdate->task_id=$stringId;
		$taskUpdate->date_added=date('Y-m-d h:i:s');
		$taskUpdate->update();	
		return $stringId;
	}
	public function defectIdUpdate($id){
		$zirolengh=6-intval(strlen($id));
		$stringId ="Defect".str_repeat("0", $zirolengh).$id;
		$defectUpdate= Defect::find()->where(['id' => $id])->one();
		$defectUpdate->defect_id=$stringId;
		$defectUpdate->date_added=date('Y-m-d h:i:s');
		$defectUpdate->update();	
		return $stringId;
	}
    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
		if(!empty($_REQUEST['multiple_del'])){
			$rows=$_REQUEST['selection'];
			for($i=0;$i<count($rows);$i++){
				$this->findModel($rows[$i])->delete();
			}
		}
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Project model.
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
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$emailObj = new SendEmail;
        $model = new Project;
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			/// Update Project
			$projectUpdate= Project::find()->where(['id' => $model->id])->one();
			$projectUpdate->added_by=Yii::$app->user->identity->id;
			$projectUpdate->added_at=strtotime(date('Y-m-d'));
			$projectUpdate->update();
			// Add Notes For Task
			if(!empty($_REQUEST['notes'])){
				$nid=NoteModel::noteInsert($model->id,$this->entity_type);
				//Note Email Send
				$emailObj->sendNoteEmailTemplate($this->getUserEmail($model->project_owner),$this->getUserFullName($model->project_owner),$this->getLoggedUserFullName()." <br/>".$_REQUEST['notes'],'<a href="'.$_SESSION['base_url'].'?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>');
				//$emailObj->emailSendMethod($this->getUserEmail($model->project_owner),"Dear ".$this->getUserFullName($model->project_owner)." <br/>A new note added to the project $link by ".$this->getLoggedUserFullName()." <br/>".$_REQUEST['notes']."<br/> Thanks", false,"Notes added to the project (".$model->project_name.")");
			}
			//Add History For Project
			HistoryModel::historyInsert($this->entity_type,$model->id,'Claim Created - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
			// add assignment history to project if the project is assigned
			if($model->project_owner != '')
			{
				$projectUserAdd = new ProjectUser();
				$projectUserAdd->project_id=$model->id;
				$projectUserAdd->user_id=$model->project_owner;
				$projectUserAdd->save();
				AssignmentHistoryModel::assignHistoryInsert($this->entity_type,$model->id,$model->project_owner,'Assigned to user');
				
			}
			if(!empty($_GET['customer_id'])){
				 return $this->redirect(['/customer/customer/customer-view', 'id' =>$_GET['customer_id']]);
			}else{
           		 return $this->redirect(['add-attachment', 'entity_id' => $model->id]);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	public function actionAddAttachment(){
			//$attachType = array('doc','xls','pdf','images','audio','vedio','zip');
			if(!empty($_FILES['attach'])){
				$file=FileModel::bulkFileInsert($_REQUEST['entity_id'],$this->entity_type);
            return $this->redirect(['project-view', 'id' => $_REQUEST['entity_id']]);
			} else {
            return $this->render('add-attachment');
        }
		
	}
    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	public function actionProjectView($id){
		$emailObj = new SendEmail;
		$model = $this->findModel($id);
		$taskModel = new Task;
		$defectModel = new Defect;
		$attachModelR=$noteModelR='';
		//Get Users 
		$projectUserModel = UserDetail::find()->where("NOT EXISTS(Select *
FROM lot_project_user  WHERE project_id =".$model->id." and user_id=lot_user.id)")->asArray()->all();

		//Add Task
		if(!empty($_REQUEST['add_task'])){
			if ($taskModel->load(Yii::$app->request->post()) && $taskModel->save()) {
				/// Create Task Id
				$stringId=$this->taskIdUdate($taskModel->id);
				HistoryModel::historyInsert('task',$taskModel->id,'Claim Created with Id  <a href="index.php?r=pmt/task/task-view&id='.$taskModel->id.'">'.$stringId.'</a>');
				//Add History For Project
				HistoryModel::historyInsert($this->entity_type,$model->id,'Add Incident for Claim (  <a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
				return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
		}
		//Add Defect
		if(!empty($_REQUEST['add_defect'])){
			if ($defectModel->load(Yii::$app->request->post()) && $defectModel->save()) {
				/// Create Task Id
				$stringId=$this->defectIdUpdate($defectModel->id);
				HistoryModel::historyInsert('defect',$defectModel->id,'Defect Created with Id  <a href="index.php?r=pmt/defect/defect-view&id='.$defectModel->id.'">'.$stringId.'</a>');
				//Add History For Project
				HistoryModel::historyInsert($this->entity_type,$model->id,'Add Defect for Project (  <a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
				return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Claim is updated - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
			// Add AssignmentHistory
			if($model->project_owner != $_REQUEST['old_owner']){ 
				AssignmentHistoryModel::assignHistoryChange($this->entity_type,$model->id,$model->project_owner,$_REQUEST['old_owner'],'Changed Project Owner  - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)',$model->added_at);
			}
            return $this->redirect(['index']);
        } else {
			// Add user for project
			if(!empty($_REQUEST['p_users'])){
				$p_users = $_REQUEST['p_users'];
				for($i=0;$i<count($p_users);$i++){
					$projectUserAdd = new ProjectUser();
					$projectUserAdd->project_id=$_REQUEST['id'];
					$projectUserAdd->user_id=$p_users[$i];
					$projectUserAdd->save();
				}
				//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Add Users For Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
				return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);	
			}
			// Send Attachment File to Task Assigned User
			if(!empty($_REQUEST['send_attachment_file'])){
				//Send an Email	
				$emailObj->emailSendMethod($_REQUEST['uemail'],$_REQUEST['email_body'], $_REQUEST['cc'], $_REQUEST['subject']);
				
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Project Attachment
			if(!empty($_REQUEST['attachment_del_id'])){
					$Attachmodel = File::findOne($_REQUEST['attachment_del_id'])->delete();
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Deleted Attachment from Claim  - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Task 
			if(!empty($_REQUEST['task_del'])){
					$taskDel = Task::findOne($_REQUEST['task_del'])->delete();
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Deleted Complain from Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Defect 
			if(!empty($_REQUEST['defect_del'])){
					$defectDel = Defect::findOne($_REQUEST['defect_del'])->delete();
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Deleted Defect from Project - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Project User  
			if(!empty($_REQUEST['udel'])){
					$ProjectUser = ProjectUser::findOne($_REQUEST['udel'])->delete();
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Project User Deleted from Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Project Notes
			if(!empty($_REQUEST['note_del_id'])){
					$NoteDel = Note::findOne($_REQUEST['note_del_id'])->delete();
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Deleted Note from Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			// Add Attachment for Project
			if(!empty($_REQUEST['add_attach'])){
				$aid=FileModel::fileInsert($_REQUEST['entity_id'],$this->entity_type);
				$link="<a href='".str_replace('web/index.php','',$_SESSION['base_url'])."attachments/".$aid.strrchr($_FILES['attach']['name'], ".")."'>".$_FILES['attach']['name']."</a>";
				// Send Email
				$emailObj->sendAddAttachmentEmailTemplate($this->getUserEmail($model->project_owner),$this->getUserFullName($model->project_owner),$link,'<a href="'.$_SESSION['base_url'].'?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>');
				//$emailObj->emailSendMethod($this->getUserEmail($model->project_owner),$link, false,$this->getLoggedUserFullName());
				//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Added Attachment into Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			// Project Attachment get
			if(!empty($_REQUEST['attach_update'])){
				$attachModelR=File::findOne($_REQUEST['attach_update']);
			}
			// Project Notes get
			if(!empty($_REQUEST['note_id'])){
				$noteModelR=Note::findOne($_REQUEST['note_id']);
			}
			// Task Attachment Update
			if(!empty($_REQUEST['edit_attach'])){
				$file=FileModel::fileEdit();
					if($_FILES['attach']['name']){
						$aid=$_REQUEST['att_id'];
						$link="<a href='".str_replace('web/index.php','',$_SESSION['base_url'])."attachments/".$aid.strrchr($_FILES['attach']['name'], ".")."'>".$_FILES['attach']['name']."</a>";
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Attachment in Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
						//Send an Email
						//$emailObj->emailSendMethod($this->getUserEmail($model->project_owner),$link, false,$this->getLoggedUserFullName());
						$emailObj->sendUpdateAttachmentEmailTemplate($this->getUserEmail($model->project_owner),$this->getUserFullName($model->project_owner),$link,'<a href="'.$_SESSION['base_url'].'?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>');
					}
					return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			
			// Add Notes
			if(!empty($_REQUEST['add_note_model'])){
				$nid = NoteModel::noteInsert($_REQUEST['id'],$this->entity_type);
				if($nid){
					setcookie('inserted_notes'.$_REQUEST['id'],true,time()+7200);
				}
				$link="<a href='".$_SESSION['base_url']."?r=pmt%2Fproject%2Fproject-view&id=".$model->id."'>".$model->project_name."</a>";
				//Send an Email
				$emailObj->sendNoteEmailTemplate($this->getUserEmail($model->project_owner),$this->getUserFullName($model->project_owner),$this->getLoggedUserFullName()." <br>".$_REQUEST['notes'],$link);
				//$emailObj->emailSendMethod($this->getUserEmail($model->project_owner),"Dear ".$this->getUserFullName($model->project_owner)." <br/>A new note added to the project $link by ".$this->getLoggedUserFullName()." <br/>".$_REQUEST['notes']."<br/> Thanks", false,"Notes added to the project (".$model->project_name.")");
				//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Added Note into  Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
				return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
			
			// Update Notes
			if(!empty($_REQUEST['edit_note_model'])){
				$nid = NoteModel::noteEdit();
				//Send an Email
				$emailObj->sendNoteUpdateEmailTemplate($this->getUserEmail($model->project_owner),$this->getUserFullName($model->project_owner),$this->getLoggedUserFullName()." <br>".$_REQUEST['notes'],'<a href="'.$_SESSION['base_url'].'?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>');
				//$emailObj->emailSendMethod($this->getUserEmail($model->project_owner)," Notes Update by ".$this->getLoggedUserFullName()." ".$_REQUEST['notes'], false,'Notes Update');
				//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Note in Claim - (<a href="index.php?r=pmt/project/project-view&id='.$model->id.'">'.$model->project_name.'</a>)');
				return $this->redirect(['project-view', 'id' => $_REQUEST['id']]);
			}
            return $this->render('project-view', [
                'model' => $model,
				'attachModel'=>$attachModelR,
				'noteModel'=>$noteModelR,
				'taskModel' =>$taskModel,
				'defectModel' =>$defectModel,
				'projectUserModel'=>$projectUserModel,
            ]);
        }
	}
    /**
     * Deletes an existing Project model.
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
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		if(Yii::$app->user->identity->user_role_id !='1'){
			if (($model = Project::find()->where("id=$id and EXISTS(Select *
FROM lot_project_user  WHERE project_id =$id and user_id=".Yii::$app->user->identity->id.")")->one()) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}else{
			if (($model = Project::findOne($id)) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}
    }
}

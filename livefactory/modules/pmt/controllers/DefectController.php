<?php

namespace livefactory\modules\pmt\controllers;

use Yii;
use yii\helpers\Html;

use livefactory\models\NoteModel;
use livefactory\models\FileModel;
use livefactory\models\AssignmentHistoryModel;
use livefactory\models\HistoryModel;
use livefactory\models\TimeDiffModel;

use livefactory\models\Defect;
use livefactory\models\File;
use livefactory\models\Note;
use livefactory\models\History;
use livefactory\models\SendEmail;
use livefactory\models\DefectPriority;
use livefactory\models\Project;
use livefactory\models\DefectTime;
use livefactory\models\TimeEntry;
use livefactory\models\DefectStatus;
use livefactory\models\User as UserDetail;
use livefactory\models\AssignmentHistory;
use livefactory\models\search\Defect as DefectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * DefectController implements the CRUD actions for Defect model.
 */
class DefectController extends Controller
{
	public $entity_type='defect';
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
	public function getProjectOwnerEmail($id){
		$projectModel = Project::findOne($id);
		$projectModelOwner = UserDetail::findOne($projectModel->project_owner);
		return $projectModelOwner->email;
	}
	public function getProjectOwnerId($id){
		$projectModel = Project::findOne($id);
		
		return $projectModel->project_owner;
	}
	public function getUserFullName($id){
		$user = UserDetail::findOne($id);
		
		return $user->first_name." ".$user->last_name;	
	}
	public function getDefectStuts($id){
		$status = DefectStatus::findOne($id);
		
		return $status->label;	
	}
	public function getLoggedUserFullName(){
		$user = UserDetail::findOne(Yii::$app->user->identity->id);
		return $user->first_name." ".$user->last_name;	
	}
	public function getLoggedUserDetail(){
		$user = UserDetail::find()->where('id='.Yii::$app->user->identity->id)->asArray()->one();
		return $user;	
	}
	public function getLoggedUserRole(){
		if(Yii::$app->user->identity->id){
		$sql="SELECT lot_user_role.label FROM lot_user_role,lot_user WHERE lot_user.id=".Yii::$app->user->identity->id." and lot_user.user_role_id=lot_user_role.id";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			//var_dump($dataReader);
		return $dataReader[0]['label'];
		}
	}
	public function getTimeDiff($start,$end){
		$hours=$day=$minutes=0;
		$timing=explode(',',TimeDiffModel::dateDiff($end,$start));
		foreach($timing as $value){
			if(strpos($value,'day') !== false){
				$day=trim(str_replace('day','',$value));
			}
			if(strpos($value,'hours') !== false){
				$hours=trim(str_replace('hours','',$value));
			}
			if(strpos($value,'minutes') !== false){
				$minutes=trim(str_replace('minutes','',$value));
			}
			if(strpos($value,'minute') !== false){
				$minutes=trim(str_replace('minute','',$value));
			}
		}
		$hours = ($day*24)+$hours;
		return $hours.".".$minutes;
		//echo $to;
		/*if($to !='-0001/11/30 00:00:00'){
		$datetime1 = new \DateTime($to);
		$datetime2 = new \DateTime($from);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%H.%I');
		if($second)
		$elapsed = $interval->format('%H.%I.%s');
		return $elapsed;
		}else{
			return '00.00';	
		}*/
	}
	public function defectTimeAdd($notes,$entity_type,$start,$end){
		$addTime= new TimeEntry();
		$addTime->entity_id=$_REQUEST['id'] ;
		$addTime->notes=$notes;
		$addTime->entity_type=$this->entity_type;
		$addTime->entry_type=$entity_type;
		$addTime->approved=$entity_type=='MANUAL'?'0':'1';
		$addTime->start_time=$start;
		$addTime->end_time=$end;
		$addTime->user_id=Yii::$app->user->identity->id;
		$addTime->added_at=strtotime(date('Y-m-d'));
		$addTime->save();	
	}
	public function defectTimeEdit($notes,$id,$start,$end){
		$editTime= TimeEntry::find()->where(['id' => $id])->one();
		$editTime->notes=$notes;
		$editTime->start_time=$start;
		$editTime->end_time=$end;
		$editTime->modified_at=strtotime(date('Y-m-d'));
		$editTime->update();	
	}
	public function defectTimeEditApproved($id){
		if(!empty($_REQUEST['approved']) && $_REQUEST['approved']=='Yes'){
			$app='1';
		}else if(!empty($_REQUEST['approved']) && $_REQUEST['approved']=='No'){
			$app='0';
		}else{
			$app='-1';
		}
		$editTime= TimeEntry::find()->where(['id' => $id])->one();
		$editTime->approved=$app;
		$editTime->modified_at=strtotime(date('Y-m-d'));
		$editTime->update();	
	}
	public function updateDefectSpendTime($id){
		$defectModel = TimeEntry::find()->where("entity_id=$id and entity_type='".$this->entity_type."'")->asArray()->all();
					
		$spend_t=0;
		$dotNumTot=0;
		$solidNumTot=0;
		foreach($defectModel as $trow1){
			list($solidNum,$dotNum) = explode('.',$this->getTimeDiff(date('Y/m/d H:i:s',strtotime($trow1['start_time'])),date('Y/m/d H:i:s',strtotime($trow1['end_time']))));
			$solidNumTot+=$solidNum;
			$dotNumTot+=$dotNum;
		}
		list($plusNum)=explode('.',$dotNumTot/60);;
		$dotVal=round($dotNumTot%60);
		$solidNum =$solidNumTot+$plusNum;
		$dotVal=strlen($dotVal)==1?"0".$dotVal:$dotVal;
		$solidNum=strlen($solidNum)==1?"0".$solidNum:$solidNum;
		$spend_t=$solidNum.".".$dotVal;
		// Update Defect Spend Time 
		$editDefect= Defect::findOne($id);//->where(['id' =>$id])->one();
		$editDefect->time_spent=$spend_t;
		$editDefect->date_modified=date('Y-m-d H:i:s');
		$editDefect->updated_at=strtotime(date('Y-m-d'));
		$editDefect->update();	
	}
	public function defectIdUdate($id){
		$zirolengh=6-intval(strlen($id));
		$stringId ="Defect".str_repeat("0", $zirolengh).$id;
		$defectUpdate= Defect::find()->where(['id' => $id])->one();
		$defectUpdate->defect_id=$stringId;
		$defectUpdate->date_added=date('Y-m-d h:i:s');
		$defectUpdate->update();
		return 	$stringId;
	}
	public function getTotalNeedAction(){
		if(Yii::$app->user->identity->user_role_id !='1'){
			return Defect::find()->where("defect_status_id=5")->count();
		}else{
			return Defect::find()->where("defect_status_id=5  and EXISTS(Select *
FROM lot_project_user  WHERE project_id ='".$defect_model->project_id."' and user_id=".Yii::$app->user->identity->id.")")->count();
		}
	}
    /**
     * Lists all Defect models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DefectSearch;
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
     * Displays a single Defect model.
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
     * Creates a new Defect model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$emailObj = new SendEmail;
        $model = new Defect;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			/// Create Defect Id
			$stringId = $this->defectIdUdate($model->id);
			
			// Add Notes For Defect
			if(!empty($_REQUEST['notes'])){
				$nid = NoteModel::noteInsert($model->id,$this->entity_type);
				// Notes Email Send ($email,$user_name,$user_by,$url)
				$emailObj->sendNoteEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$stringId.'</a>');
			}
			
			
			//Add History For Defect
			HistoryModel::historyInsert($this->entity_type,$model->id,'Defect Created with Id  <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$stringId.'</a>');
			
			// Entry on Assigned History
			if($model->assigned_user_id){
				AssignmentHistoryModel::assignHistoryInsert($this->entity_type,$model->id,$model->assigned_user_id,'Defect Assigned to user');
				//Email Send  sendDefectEmailTemplate($email,$user_name,$url,$desc)
				$emailObj->sendDefectEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$stringId.'</a>',$model->defect_description); 
			}
            return $this->redirect(['add-attachment', 'entity_id' => $model->id,'user_id'=>$model->assigned_user_id]);
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
			
            return $this->redirect(['defect-view', 'id' => $_REQUEST['entity_id']]);
			} else {
            return $this->render('add-attachment');
        }
		
	}
    /**
     * Updates an existing Defect model.
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
	public function getDateTimeFormat($date){
		$datetime = new \DateTime($date);
		return $datetime->format('Y-m-d H:i:s');	
	}
	public function actionDefectView($id)
    {
		$user_id=1;
        $model = $this->findModel($id);
		$sub_defect = new Defect;
		$emailObj = new SendEmail;
		$attachModelR='';
		$noteModelR='';
		//Add Sub Defect
		if(!empty($_REQUEST['defectid'])){
			if ($sub_defect->load(Yii::$app->request->post()) && $sub_defect->save()) {
				
				/// Create Defect Id
				$stringId = $this->defectIdUdate($sub_defect->id);
				$subDefectUpdate = Defect::findOne($sub_defect->id);
				$subDefectUpdate->expected_start_datetime = $this->getDateTimeFormat($_REQUEST['Defect']['expected_start_datetime']);
				$subDefectUpdate->expected_end_datetime = $this->getDateTimeFormat($_REQUEST['Defect']['expected_end_datetime']);
				$subDefectUpdate->actual_start_datetime = $this->getDateTimeFormat($_REQUEST['Defect']['actual_start_datetime']);
				$subDefectUpdate->actual_end_datetime = $this->getDateTimeFormat($_REQUEST['Defect']['actual_end_datetime']);
				$subDefectUpdate->update();
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$subDefectUpdate->id,'Defect Created with Id  <a href="index.php?r=pmt/defect/defect-view&id='.$subDefectUpdate->id.'">'.$stringId.'</a>');
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Sub Defect Created with Id  <a href="index.php?r=pmt/defect/defect-view&id='.$subDefectUpdate->id.'">'.$stringId.'</a>');
				return $this->redirect(['defect-view', 'id' => $_REQUEST['defectid']]);
			}
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$old_owner=!empty($_REQUEST['old_owner'])?$_REQUEST['old_owner']:'';
			$old_defect_priority_id=!empty($_REQUEST['old_defect_priority_id'])?$_REQUEST['old_defect_priority_id']:'';
			$old_defect_status_id=!empty($_REQUEST['old_defect_status_id'])?$_REQUEST['old_defect_status_id']:'';
			/// Assigned user Changed
			if($model->assigned_user_id != $old_owner){				
				//Send an Email
				$emailObj->sendDefectChangedUserEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>',$this->getDefectStuts($model->defect_status_id));
				
				// Add AssignmentHistory
				AssignmentHistoryModel::assignHistoryChange($this->entity_type,$model->id,$model->assigned_user_id,$old_owner,"Changed Assigned User",$model->added_at);
				
				//Add History
				HistoryModel::historyInsert($this->entity_type,$model->id,"History is updated as Defect is assigned to ".$this->getUserFullName($model->assigned_user_id)." by ".$this->getUserFullName($old_owner).' into ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
			}
			
			/// Defect Priority Changed
			if($model->defect_priority_id != $old_defect_priority_id){
				$defectPriorityModel = DefectPriority::findOne($model->defect_priority_id);
				$defectPriorityModelOld = DefectPriority::findOne($old_defect_priority_id);
				//Add History
				HistoryModel::historyInsert($this->entity_type,$model->id,"Defect priority changed from ".$defectPriorityModelOld->label." to ".$defectPriorityModel->label." by ".$this->getLoggedUserFullName().'  into ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
				
				//Send an Email
				$emailObj->sendDefectChangedPriorityEmailTemplate($this->getUserEmail($model->assigned_user_id).",".$this->getProjectOwnerEmail($model->project_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>',$defectPriorityModelOld->label,$defectPriorityModel->label);
				
			}
			
			/// Defect Status Changed
			if($model->defect_status_id != $old_defect_status_id){
				$defectStatusModel = DefectStatus::findOne($model->defect_status_id);
				$defectStatusModelOld = DefectStatus::findOne($old_defect_status_id);
				//Add History
				HistoryModel::historyInsert($this->entity_type,$model->id,"Defect status changed from ".$defectStatusModelOld->label." to ".$defectStatusModel->label." by ".$this->getLoggedUserFullName().'  into ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
				//Send an Email
				$emailObj->sendDefectChangedStatusEmailTemplate($this->getUserEmail($model->assigned_user_id).",".$this->getProjectOwnerEmail($model->project_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>',$defectStatusModelOld->label,$defectStatusModel->label);
				
			}
			//Add History
			HistoryModel::historyInsert($this->entity_type,$model->id,'Defect is updated ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
            return $this->redirect(['index']);
        } else {
			$timeEntryModel = new TimeEntry();
			// Send Attachment File to Defect Assigned User
			if(!empty($_REQUEST['send_attachment_file'])){
				//Send an Email
				$emailObj->emailSendMethod($_REQUEST['uemail'],$_REQUEST['email_body'], $_REQUEST['cc'], $_REQUEST['subject']);
					return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Defect Attachment
			if(!empty($_REQUEST['attachment_del_id'])){
					$Attachmodel = File::findOne($_REQUEST['attachment_del_id'])->delete();
					//Add History For Defect
					HistoryModel::historyInsert($this->entity_type,$model->id,$model->defect_id.' Defect Attachment Deleted from ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
					return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Defect 
			if(!empty($_REQUEST['defect_del'])){
					$defectDel = Defect::findOne($_REQUEST['defect_del'])->delete();
					//Add History For Defect
					HistoryModel::historyInsert($this->entity_type,$model->id,$model->defect_id.' Defect SubDefect  Deleted from ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
					return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Defect Notes
			if(!empty($_REQUEST['note_del_id'])){
					$NoteDel = Note::findOne($_REQUEST['note_del_id'])->delete();
					//Add History For Defect
					HistoryModel::historyInsert($this->entity_type,$model->id,$model->defect_id.'Defect Note  Deleted from ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
					return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			
			
			// Add Attachment for Defect
			if(!empty($_REQUEST['add_attach'])){
				$aid=FileModel::fileInsert($_REQUEST['entity_id'],$this->entity_type);
				$link="<a href='".str_replace('web/index.php','',$_SESSION['base_url'])."attachments/".$aid.strrchr($_FILES['attach']['name'], ".")."'>".$_FILES['attach']['name']."</a>";
				$emailObj->sendAddAttachmentEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$link,'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>');
				
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Attachment into ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
					return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			
			
			
			// Defect Attachment get
			if(!empty($_REQUEST['attach_update'])){
				$attachModelR=File::findOne($_REQUEST['attach_update']);
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,$model->defect_id.' Defect Attachment Updated in ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
			}
			// Defect Notes get
			if(!empty($_REQUEST['note_id'])){
				$noteModelR=Note::findOne($_REQUEST['note_id']);
			}
			// Defect Attachment Update
			if(!empty($_REQUEST['edit_attach'])){
					$file=FileModel::fileEdit();
					if($_FILES['attach']['name']){
						$aid=$_REQUEST['att_id'];
						$link="<a href='".str_replace('web/index.php','',$_SESSION['base_url'])."attachments/".$aid.strrchr($_FILES['attach']['name'], ".")."'>".$_FILES['attach']['name']."</a>";
						//Send an Email
						$emailObj->sendUpdateAttachmentEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$link,'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>');
						
					}
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Attachment in ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
					return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			
			// Add Notes
			if(!empty($_REQUEST['add_note_model'])){
				$nid = NoteModel::noteInsert($_REQUEST['id'],$this->entity_type);
				if($nid){
					setcookie('inserted_notes'.$_REQUEST['id'],true,time()+7200);
				}
				//Send an Email
				$emailObj->sendNoteEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName()." <br>".$_REQUEST['notes'],'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>');
			//	$emailObj->emailSendMethod($this->getUserEmail($model->assigned_user_id),"A new note added by ".$this->getLoggedUserFullName()." ".$_REQUEST['notes'], false,'New Note Added');
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Note into ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
				return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			
			// Update Notes
			if(!empty($_REQUEST['edit_note_model'])){
				$nid = NoteModel::noteEdit();
				//Send an Email
				$emailObj->sendNoteUpdateEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName()." <br>".$_REQUEST['notes'],'<a href="'.$_SESSION['base_url'].'?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>');
				
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Note in ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
				return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			// Add Defect Timing
			if(!empty($_REQUEST['defect_timing_add'])){
				$this->defectTimeAdd($_REQUEST['notes'],'MANUAL',$_REQUEST['start_time'],$_REQUEST['end_time']);
				// Update Defect Spend Time
				$this->updateDefectSpendTime($_REQUEST['id']);
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Defect Work Timing into ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
				return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			if(!empty($_REQUEST['time_entry_id'])){
				$timeEntryModel = TimeEntry::findOne($_REQUEST['time_entry_id']);
			}
			// Edit Defect Timing
			if(!empty($_REQUEST['defect_timing_edit'])){
				$this->defectTimeEdit($_REQUEST['notes'],$_REQUEST['time_entry_id'],$_REQUEST['start_time'],$_REQUEST['end_time']);
				// Update Defect Spend Time
				$this->updateDefectSpendTime($_REQUEST['id']);
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Defect Work Timing in ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
				return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			// Edit Defect defectTimeEditApproved
			if(!empty($_REQUEST['appid'])){
				$this->defectTimeEditApproved($_REQUEST['appid']);
				return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			// Delete Defect Attachment
			if(!empty($_REQUEST['time_del_id'])){
					$Attachmodel = TimeEntry::findOne($_REQUEST['time_del_id'])->delete();
					// Update Defect Spend Time
					$this->updateDefectSpendTime($_REQUEST['id']);
					//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Deleted Defect Work Timing from  ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
					return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			if(!empty($_REQUEST['starttime'])){
				date_default_timezone_set('Asia/Kolkata');
				setcookie('defect_start_time',date('Y-m-d H:i:s'),time()+7200);
				setcookie('defectStartedId',$_REQUEST['id'],time()+7200);
				 return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
			if(!empty($_REQUEST['defectnotes']) && !empty($_COOKIE['defect_start_time'])){
				date_default_timezone_set('Asia/Kolkata');
				$start_time=$_COOKIE['defect_start_time'];
				$end_time = date('Y-m-d H:i:s');
				// Add Defect Time
				$this->defectTimeAdd($_REQUEST['defectnotes'],'AUTO',$start_time,$end_time);
				setcookie('defect_start_time',date('Y-m-d H:i:s'),time()-3600);
				setcookie('defectStartedId',$_REQUEST['id'],time()-3600);
				// Update Defect Spend Time
				$this->updateDefectSpendTime($_REQUEST['id']);
				//Add History For Defect
				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Note into ( <a href="index.php?r=pmt/defect/defect-view&id='.$model->id.'">'.$model->defect_id.'</a>)');
				return $this->redirect(['defect-view', 'id' => $_REQUEST['id']]);
			}
            return $this->render('defect-view', [
                'model' => $model,
				'attachModel'=>$attachModelR,
				'noteModel'=>$noteModelR,
				'sub_defect'=>$sub_defect,
				'timeEntryModel'=>$timeEntryModel,
            ]);
        }
    }
	public function actionAjaxDefect($id){
		$start_time=!empty($_REQUEST['start_time'])?$_REQUEST['start_time']:'';
		$eid=!empty($_REQUEST['eid'])?$_REQUEST['eid']:'';
		if($eid){
			$defectModel = TimeEntry::find()->where("id != $eid and entity_id=$id and entity_type='defect' and start_time<='$start_time' and end_time >='$start_time'")->one();
		}else{
		$defectModel = TimeEntry::find()->where("entity_id=$id and entity_type='defect' and start_time<='$start_time' and end_time >='$start_time'")->one();	
		}
		 return $this->renderPartial('ajax-defect', [
                'name' => $defectModel->id,
            ]);
	}
	
	public function actionAjaxDefectTimeDateValidation(){
		$start_time=$_REQUEST['start_time'];
		$end_time=$_REQUEST['end_time'];
		if($end_time){
			list($hours,$min)=explode('.',$this->getTimeDiff($start_time,$end_time));
			$error='';
			if(intval($hours) > 23){
				$error='yes';	
			}else{
				$error='no';	
			}
		}
		 return $this->renderPartial('ajax-defect-time-date-validation', [
                'error' =>$error,
            ]);
	}
	public function getSpentTime($enity_id,$user_id){
		$defectModel = TimeEntry::find()->where("entity_id=$enity_id and entity_type='".$this->entity_type."'")->asArray()->all();
					
		$spend_t=0;
		$dotNumTot=0;
		$solidNumTot=0;
		foreach($defectModel as $trow1){
			list($solidNum,$dotNum) = explode('.',$this->getTimeDiff(date('Y/m/d H:i:s',strtotime($trow1['start_time'])),date('Y/m/d H:i:s',strtotime($trow1['end_time']))));
			$solidNumTot+=$solidNum;
			$dotNumTot+=$dotNum;
		}
		list($plusNum)=explode('.',$dotNumTot/60);;
		$dotVal=round($dotNumTot%60);
		$solidNum =$solidNumTot+$plusNum;
		$dotVal=strlen($dotVal)==1?"0".$dotVal:$dotVal;
		$solidNum=strlen($solidNum)==1?"0".$solidNum:$solidNum;
		$spend_t=$solidNum.":".$dotVal;	
		return $solidNum;
	}
	public function actionDefectClosedReports(){
		date_default_timezone_set('Asia/Kolkata');
		$start_date= !empty($_REQUEST['start_date'])?$_REQUEST['start_date']:'';
		$date=!empty($_REQUEST['date'])?$_REQUEST['date']:'this_month';
		$end_date=!empty($_REQUEST['end_date'])?$_REQUEST['end_date']:'';
		$weekStartDate = date('Y-m-d',strtotime('last monday'));
		$lastMonthFirstDate = date('Y-m-d',strtotime('first day of last month'));
		$lastMonthLastDate = date('Y-m-d',strtotime('last day of last month'));
		$monthFirstDate = date('Y-m-d',strtotime('first day of this month'));
		$curdate=date('Y-m-d');
		$filter=array('today','yesterday');
		if(!in_array($date,$filter)){
		
			$sql="SELECT lot_user.first_name,lot_user.last_name,count(lot_defect.id) counts,date(lot_defect.actual_end_datetime) actual_end_datetime FROM `lot_defect`,lot_user WHERE lot_defect.assigned_user_id=lot_user.id and defect_status_id=2 ";
			
			if($date=='last_month'){
				 $sql.=" and  date(actual_end_datetime) >='$lastMonthFirstDate' and date(actual_end_datetime)<='$lastMonthLastDate' ";	
			}
			if($date=='this_month'){
				 $sql.=" and  date(actual_end_datetime) >='$monthFirstDate' and date(actual_end_datetime)<='$curdate'";	
			}
			if($date=='this_week'){
				 $sql.=" and  date(actual_end_datetime) >='$weekStartDate' and date(actual_end_datetime)<='$curdate' ";	
			}
			if(!empty($start_date) && !empty($end_date)){
				 $sql.=" and  date(actual_end_datetime) >='$start_date' and date(actual_end_datetime)<='$end_date' ";	
			}
			$sql .="  GROUP BY date(actual_end_datetime),lot_defect.assigned_user_id ORDER by date(actual_end_datetime)";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
		}else{
			$date_value=$date=='today'?date('Y-m-d'):date('Y-m-d',strtotime("-1 days"));
			
			$sql="SELECT lot_user.first_name,
						lot_user.last_name,lot_user.id uid,
						DATE_FORMAT(lot_defect.actual_end_datetime,'%H') actual_end_datetime,
						lot_defect.assigned_user_id,lot_defect.id tid,count(lot_defect.id) defectcount FROM `lot_defect`,lot_user WHERE lot_defect.assigned_user_id=lot_user.id and defect_status_id=2  and  date(actual_end_datetime) = '$date_value'  GROUP BY DATE_FORMAT(lot_defect.actual_end_datetime,'%H'),lot_defect.assigned_user_id ORDER by assigned_user_id,date(actual_end_datetime)";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			}
			return $this->render('defect-closed-reports', [
				'dataProvider' => $dataReader,
			]);
		
	}
	public function getNeedActions($project_id){
		$defectModel = Defect::find()->joinWith('user')->where("project_id=$project_id and defect_status_id=5")->orderBy('actual_end_datetime')->asArray()->all();
		return $defectModel;
	}
	public function getInprocessDefects($project_id){
		$defectModel = Defect::find()->joinWith('user')->where("project_id=$project_id and defect_status_id=1")->orderBy('actual_end_datetime')->asArray()->all();
		return $defectModel;
	}
	public function getWeakClosedDefects($project_id){
		date_default_timezone_set('Asia/Kolkata');
		$weekStartDate = date('Y-m-d',strtotime('last monday'));
		$curdate=date('Y-m-d');
		$defectModel = Defect::find()->joinWith('user')->where("project_id=$project_id and defect_status_id=2 and date(actual_end_datetime) >='$weekStartDate' and date(actual_end_datetime) <='$curdate'")->orderBy('actual_end_datetime')->asArray()->all();
		
		return $defectModel;
	}
	public function getMonthClosedDefects($project_id){
		date_default_timezone_set('Asia/Kolkata');
		$monthFirstDate = date('Y-m-d',strtotime('first day of this month'));
		$curdate=date('Y-m-d');
		$defectModel = Defect::find()->joinWith('user')->where("project_id=$project_id and defect_status_id=2 and date(actual_end_datetime) >='$monthFirstDate' and date(actual_end_datetime) <='$curdate'")->orderBy('actual_end_datetime')->asArray()->all();
		return $defectModel;
	}
	public function getTotalUserSpentTime($uid,$date){
	  $sql="select lot_time_entry.* from lot_time_entry,lot_defect where lot_defect.assigned_user_id='$uid' and lot_defect.id=lot_time_entry.entity_id and date(start_time)='$date'";
	  $connection = \Yii::$app->db;
	  $command=$connection->createCommand($sql);
	  $dataReader=$command->queryAll();
					
		$spend_t=0;
		$dotNumTot=0;
		$solidNumTot=0;
		foreach($dataReader as $trow1){
			list($solidNum,$dotNum) = explode('.',$this->getTimeDiff(date('Y/m/d H:i:s',strtotime($trow1['start_time'])),date('Y/m/d H:i:s',strtotime($trow1['end_time']))));
			$solidNumTot+=$solidNum;
			$dotNumTot+=$dotNum;
		}
		list($plusNum)=explode('.',$dotNumTot/60);;
		$dotVal=round($dotNumTot%60);
		$solidNum =$solidNumTot+$plusNum;
		$dotVal=strlen($dotVal)==1?"0".$dotVal:$dotVal;
		$solidNum=strlen($solidNum)==1?"0".$solidNum:$solidNum;
		$spend_t=$solidNum.".".$dotVal;
		return $spend_t;
  }
	public function actionTimeSpentReport(){
		date_default_timezone_set('Asia/Kolkata');
		$start_date=!empty($_REQUEST['start_date'])?$_REQUEST['start_date']:'';
		$date=!empty($_REQUEST['date'])?$_REQUEST['date']:'this_month';
		$end_date=!empty($_REQUEST['end_date'])?$_REQUEST['end_date']:'';
		$weekStartDate = date('Y-m-d',strtotime('last monday'));
		$lastMonthFirstDate = date('Y-m-d',strtotime('first day of last month'));
		$lastMonthLastDate = date('Y-m-d',strtotime('last day of last month'));
		$monthFirstDate = date('Y-m-d',strtotime('first day of this month'));
		$lastWeekStartDate=date('Y-m-d',strtotime(date('Y-m-d',strtotime('last monday'))."- 7 days"));
		$lastWeekEndDate=date('Y-m-d',strtotime('last sunday'));
		$curdate=date('Y-m-d');
		$sql="SELECT lot_project.id pid,lot_user.first_name,lot_defect.assigned_user_id,lot_project.project_name,lot_defect.id tid,lot_defect.defect_id, lot_defect.defect_name,lot_defect.actual_end_datetime,lot_time_entry.* FROM `lot_project`,lot_defect,lot_time_entry,lot_user WHERE lot_user.id=lot_defect.assigned_user_id and lot_project.id=lot_defect.project_id and lot_defect.id=lot_time_entry.entity_id and lot_time_entry.entity_type='defect' ";
			if($date=='last_month'){
				 $sql.=" and  date(end_time) >='$lastMonthFirstDate' and date(end_time)<='$lastMonthLastDate' ";	
			}
			if($date=='this_month'){
				 $sql.=" and  date(end_time) >='$monthFirstDate' and date(end_time)<='$curdate'";	
			}
			if($date=='this_week'){
				 $sql.=" and  date(end_time) >='$weekStartDate' and date(end_time)<='$curdate' ";	
			}
			if($date=='last_week'){
				 $sql.=" and  date(end_time) >='$lastWeekStartDate' and date(end_time)<='$lastWeekEndDate' ";	
			}
			if(!empty($start_date) && !empty($end_date)){
				 $sql.=" and  date(end_time) >='$start_date' and date(end_time)<='$end_date' ";	
			}
		$sql.="  ORDER by  date(end_time), defect_name";
		//echo $sql;	
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			$users=array();
			$data=array();
			foreach($dataReader as $row){
				$users[$row['assigned_user_id']]=$row['first_name'];
				$data[$row['assigned_user_id']][date('Y-m-d',strtotime($row['end_time']))]=$this->getTotalUserSpentTime($row['assigned_user_id'],date('Y-m-d',strtotime($row['end_time'])));
			}
			return $this->render('time-spent-report', [
				'dataProvider' => $dataReader,
				'users'=>$users,
				'data'=>$data,
			]);
		return $defectModel;
	}
	public function actionAutomail(){
		$sql="SELECT lot_user.first_name,lot_user.last_name,lot_project.id,lot_project.project_name FROM `lot_project`,lot_user WHERE lot_project.project_owner=lot_user.id";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			return $this->render('automail', [
				'dataProvider' => $dataReader,
			]);
	}
	public function actionAjaxProjectUsers(){
		$project_id=$_REQUEST['project_id'];
		$user_id=$_REQUEST['user_id'];
		$sql="SELECT * FROM lot_user WHERE id in(select user_id from lot_project_user where project_id=$project_id)";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
		 return $this->renderPartial('ajax-project-users', [
                'dataReader' => $dataReader,
				'user_id'=>$user_id,
            ]);
	}
	public function actionAjaxUserProjects(){
		$project_id=$_REQUEST['project_id'];
		$user_id=$_REQUEST['user_id'];
		$sql="SELECT * FROM lot_project WHERE id in(select project_id from lot_project_user where user_id=$user_id)";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
		 return $this->renderPartial('ajax-user-projects', [
                'dataReader' => $dataReader,
				'user_id'=>$user_id,
				'project_id'=>$project_id,
            ]);
	}
	public function actionMyCalendar(){
		$sql = "SELECT *, date(expected_start_datetime)   expected_start_datetime,IF(defect_status_id=2,date(actual_end_datetime),date(expected_end_datetime))  expected_end_datetime FROM lot_defect  where assigned_user_id = '".Yii::$app->user->identity->id."' order by id DESC limit 100";
			$connection = \Yii::$app->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			//echo count($dataReader);
			return $this->render('my-calendar', [
				'dataProvider' => $dataReader,
			]);
	}
    /**
     * Deletes an existing Defect model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionNeedActions(){
		$searchModel = new DefectSearch;
        $dataProvider = $searchModel->searchNeedActions(Yii::$app->request->getQueryParams());
        return $this->render('need-actions', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
	}
	public function actionMyDefects(){
		if(!empty($_REQUEST['multiple_del'])){
			$rows=$_REQUEST['selection'];
			for($i=0;$i<count($rows);$i++){
				$this->findModel($rows[$i])->delete();
			}
		}
		$searchModel = new DefectSearch;
        $dataProvider = $searchModel->searchMyDefects(Yii::$app->request->getQueryParams());
        return $this->render('my-defects', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
	}
	public function actionDefectAllReports(){
			
            return $this->render('defect-all-reports');
		
	}
	public function actionDefectAssignmentReport(){
			
            return $this->render('defect-assignment-report');
		
	}
    /**
     * Finds the Defect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Defect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		if(Yii::$app->user->identity->user_role_id !='1'){
			$defect_model = Defect::findOne($id);
			if (($model = Defect::find()->where("id=$id and EXISTS(Select *
FROM lot_project_user  WHERE project_id ='".$defect_model->project_id."' and user_id=".Yii::$app->user->identity->id.")")->one()) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}else{
			if (($model = Defect::findOne($id)) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}
    }
	
}

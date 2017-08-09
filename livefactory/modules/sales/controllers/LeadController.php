<?php



namespace livefactory\modules\sales\controllers;



use Yii;

use yii\helpers\Html;

use livefactory\models\NoteModel;

use livefactory\models\FileModel;

use livefactory\models\AssignmentHistoryModel;

use livefactory\models\HistoryModel;

use livefactory\models\TimeDiffModel;





use livefactory\models\File;

use livefactory\models\Note;

use livefactory\models\History;

use livefactory\models\SendEmail;

use livefactory\models\TimeEntry;

use livefactory\models\User as UserDetail;

use livefactory\models\AssignmentHistory;



use livefactory\models\Lead;

use livefactory\models\LeadStatus;

use livefactory\models\LeadType;

use livefactory\models\LeadPriority;

use livefactory\models\Customer;

use livefactory\models\search\Lead as LeadSearch;

use yii\web\Controller;

use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;

use livefactory\models\search\CommonModel as SessionVerification;

/**

 * LeadController implements the CRUD actions for Lead model.

 */

class LeadController extends Controller

{

	public $entity_type='lead';

	public $view_page='?r=sales/lead/lead-view&id=';

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

	public function getUserEmail($id){

		$userModel = UserDetail::findOne($id);	

		return $userModel->email;

	}

	public function getCustomerEmail($id){

		$customerModel = Customer::findOne($id);

		return $customerModel->email;

	}

	public function getUserFullName($id){

		$user = UserDetail::findOne($id);

		

		return $user->first_name." ".$user->last_name;	

	}

	public function getLeadStuts($id){

		$status = LeadStatus::findOne($id);

		

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

	}

	public function leadTimeAdd($notes,$entity_type,$start,$end){

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

	public function leadTimeEdit($notes,$id,$start,$end){

		$editTime= TimeEntry::find()->where(['id' => $id])->one();

		$editTime->notes=$notes;

		$editTime->start_time=$start;

		$editTime->end_time=$end;

		$editTime->modified_at=strtotime(date('Y-m-d'));

		$editTime->update();	

	}

	public function leadTimeEditApproved($id){

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

	public function updateLeadSpendTime($id){

		$leadModel = TimeEntry::find()->where("entity_id=$id and entity_type='".$this->entity_type."'")->asArray()->all();

					

		$spend_t=0;

		$dotNumTot=0;

		$solidNumTot=0;

		foreach($leadModel as $trow1){

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

		// Update Lead Spend Time 

		$editLead= Lead::findOne($id);//->where(['id' =>$id])->one();

		$editLead->time_spent=$spend_t;

		$editLead->date_modified=date('Y-m-d H:i:s');

		$editLead->updated_at=strtotime(date('Y-m-d'));

		$editLead->update();	

	}

	public function leadIdUdate($id){

		$zirolengh=6-intval(strlen($id));

		$stringId ="LEAD".str_repeat("0", $zirolengh).$id;

		$leadUpdate= Lead::find()->where(['id' => $id])->one();

		$leadUpdate->lead_id=$stringId;

		$leadUpdate->date_added=date('Y-m-d h:i:s');

		$leadUpdate->update();

		return 	$stringId;

	}

	public function getDateTimeFormat($date){

		$datetime = new \DateTime($date);

		return $datetime->format('Y-m-d H:i:s');	

	}

    /**

     * Lists all Lead models.

     * @return mixed

     */

    public function actionIndex()

    {

        $searchModel = new LeadSearch;

        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());



        return $this->render('index', [

            'dataProvider' => $dataProvider,

            'searchModel' => $searchModel,

        ]);

    }



    /**

     * Displays a single Lead model.

     * @param integer $id

     * @return mixed

     */

	public function init(){

		SessionVerification::checkSessionDestroy();

    	if(empty(Yii::$app->user->identity->id)){

          $this->redirect(array('/site/login'));

		}

	}

    public function actionView($id)

    {

        $model = $this->findModel($id);

		if(!empty($_REQUEST['multiple_del'])){

			$rows=$_REQUEST['selection'];

			for($i=0;$i<count($rows);$i++){

				$this->findModel($rows[$i])->delete();

			}

		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        return $this->redirect(['view', 'id' => $model->id]);

        } else {

        return $this->render('view', ['model' => $model]);

}

    }



    /**

     * Creates a new Lead model.

     * If creation is successful, the browser will be redirected to the 'view' page.

     * @return mixed

     */

    public function actionCreate()

    {

        $model = new Lead;

		$emailObj = new SendEmail;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

			/// Create Lead Id

			$stringId = $this->leadIdUdate($model->id);

			

			// Add Notes

			if(!empty($_REQUEST['notes'])){

				$nid = NoteModel::noteInsert($model->id,$this->entity_type);

				$emailObj->sendNoteEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$stringId.'</a>');

				

			}

			//Add History

			HistoryModel::historyInsert($this->entity_type,$model->id,'Lead Created with Id  <a href="index.php'.$this->view_page.$model->id.'">'.$stringId.'</a>');

			

			// Entry on Assigned History

			if($model->assigned_user_id){

				AssignmentHistoryModel::assignHistoryInsert($this->entity_type,$model->id,$model->assigned_user_id,'Lead Assigned to user');

				//Email Send  sendLeadEmailTemplate($email,$user_name,$url,$desc)

				$emailObj->sendLeadEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$stringId.'</a>',$model->lead_description);

			}

				

           return $this->redirect(['add-attachment', 'entity_id' => $model->id]);

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

			

            return $this->redirect(['lead-view', 'id' => $_REQUEST['entity_id']]);

			} else {

            return $this->render('add-attachment');

        }

		

	}

    /**

     * Updates an existing Lead model.

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

	public function actionLeadView($id)

    {

		$sub_lead = new Lead();

        $model = $this->findModel($id);

		

		$emailObj = new SendEmail;

		$attachModelR='';

		$noteModelR='';

		//Add Sub Lead

		if(!empty($_REQUEST['sub_lead_value'])){

			if ($sub_lead->load(Yii::$app->request->post()) && $sub_lead->save()) {

				/// Create Lead Id

				$stringId = $this->leadIdUdate($sub_lead->id);

				$subLeadUpdate = Lead::findOne($sub_lead->id);

				$subLeadUpdate->expected_start_datetime = $this->getDateTimeFormat($_REQUEST['Lead']['expected_start_datetime']);

				$subLeadUpdate->expected_end_datetime = $this->getDateTimeFormat($_REQUEST['Lead']['expected_end_datetime']);

				$subLeadUpdate->actual_start_datetime = $this->getDateTimeFormat($_REQUEST['Lead']['actual_start_datetime']);

				$subLeadUpdate->actual_end_datetime = $this->getDateTimeFormat($_REQUEST['Lead']['actual_end_datetime']);

				$subLeadUpdate->update();

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$subLeadUpdate->id,'Lead Created with Id  <a href="index.php'.$this->view_page.$subLeadUpdate->id.'">'.$stringId.'</a>');

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,'Sub Lead Created with Id  <a href="index.php'.$this->view_page.$subLeadUpdate->id.'">'.$stringId.'</a>');

				return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

		}

        if (empty($_REQUEST['sub_lead_value']) && $model->load(Yii::$app->request->post()) && $model->save()) {

			$old_owner=!empty($_REQUEST['old_owner'])?$_REQUEST['old_owner']:'';

			$old_lead_priority_id=!empty($_REQUEST['old_lead_priority_id'])?$_REQUEST['old_lead_priority_id']:'';

			$old_lead_status_id=!empty($_REQUEST['old_lead_status_id'])?$_REQUEST['old_lead_status_id']:'';

			/// Assigned user Changed

			if($model->assigned_user_id != $old_owner){				

				//Send an Email

				$emailObj->sendLeadChangedUserEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$model->lead_id.'</a>',$this->getLeadStuts($model->lead_status_id));

				AssignmentHistoryModel::assignHistoryChange($this->entity_type,$model->id,$model->assigned_user_id,$old_owner,"Changed Assigned User",$model->added_at);

				

				//Add History

				HistoryModel::historyInsert($this->entity_type,$model->id,"History is updated as Lead is assigned to ".$this->getUserFullName($model->assigned_user_id)." by ".$this->getUserFullName($old_owner).' into ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

			}

			

			/// Lead Priority Changed

			if($model->lead_priority_id != $old_lead_priority_id){

				$leadPriorityModel = LeadPriority::findOne($model->lead_priority_id);

				$leadPriorityModelOld = LeadPriority::findOne($old_lead_priority_id);

				//Add History

				HistoryModel::historyInsert($this->entity_type,$model->id,"Lead priority changed from ".$leadPriorityModelOld->label." to ".$leadPriorityModel->label." by ".$this->getLoggedUserFullName().'  into ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

				

				//Send an Email

				$emailObj->sendLeadChangedPriorityEmailTemplate($this->getUserEmail($model->assigned_user_id).",".$this->getCustomerEmail($model->customer_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$model->lead_id.'</a>',$leadPriorityModelOld->label,$leadPriorityModel->label);

				

			}

			

			/// Lead Status Changed

			if($model->lead_status_id != $old_lead_status_id){

				$leadStatusModel = LeadStatus::findOne($model->lead_status_id);

				$leadStatusModelOld = LeadStatus::findOne($old_lead_status_id);

				//Add History

				HistoryModel::historyInsert($this->entity_type,$model->id,"Lead status changed from ".$leadStatusModelOld->label." to ".$leadStatusModel->label." by ".$this->getLoggedUserFullName().'  into ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

				//Send an Email

				$emailObj->sendLeadChangedStatusEmailTemplate($this->getUserEmail($model->assigned_user_id).",".$this->getCustomerEmail($model->customer_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName(),'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$model->lead_id.'</a>',$leadStatusModelOld->label,$leadStatusModel->label);

				

			}

			//Add History

			HistoryModel::historyInsert($this->entity_type,$model->id,'Lead is updated ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

            return $this->redirect(['index']);

        } else {

			$timeEntryModel = new TimeEntry();

			// Send Attachment File to Lead Assigned User

			if(!empty($_REQUEST['send_attachment_file'])){

				//Send an Email

				$emailObj->emailSendMethod($_REQUEST['uemail'],$_REQUEST['email_body'], $_REQUEST['cc'], $_REQUEST['subject']);

					return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			// Delete  Attachment

			if(!empty($_REQUEST['attachment_del_id'])){

					$Attachmodel = File::findOne($_REQUEST['attachment_del_id'])->delete();

					//Add History 

					HistoryModel::historyInsert($this->entity_type,$model->id,$model->lead_id.' Lead Attachment Deleted from ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

					return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			// Delete Lead 

			if(!empty($_REQUEST['lead_del'])){

					$leadDel = Lead::findOne($_REQUEST['lead_del'])->delete();

					//Add History 

					HistoryModel::historyInsert($this->entity_type,$model->id,$model->lead_id.' Lead SubLead  Deleted from ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

					return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			// Delete  Notes

			if(!empty($_REQUEST['note_del_id'])){

					$NoteDel = Note::findOne($_REQUEST['note_del_id'])->delete();

					//Add History 

					HistoryModel::historyInsert($this->entity_type,$model->id,$model->lead_id.'Lead Note  Deleted from ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

					return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			

			

			// Add Attachment for Lead

			if(!empty($_REQUEST['add_attach'])){

				$aid=FileModel::fileInsert($_REQUEST['entity_id'],$this->entity_type);

				$link="<a href='".str_replace('web/index.php','',$_SESSION['base_url'])."attachments/".$aid.strrchr($_FILES['attach']['name'], ".")."'>".$_FILES['attach']['name']."</a>";

				$emailObj->sendAddAttachmentEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$link,'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$model->lead_id.'</a>');

				

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Attachment into ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

					return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			

			

			

			// Lead Attachment get

			if(!empty($_REQUEST['attach_update'])){

				$attachModelR=File::findOne($_REQUEST['attach_update']);

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,$model->lead_id.' Lead Attachment Updated in ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

			}

			// Lead Notes get

			if(!empty($_REQUEST['note_id'])){

				$noteModelR=Note::findOne($_REQUEST['note_id']);

			}

			// Lead Attachment Update

			if(!empty($_REQUEST['edit_attach'])){

					$file=FileModel::fileEdit();

					if($_FILES['attach']['name']){

						$aid=$_REQUEST['att_id'];

						$link="<a href='".str_replace('web/index.php','',$_SESSION['base_url'])."attachments/".$aid.strrchr($_FILES['attach']['name'], ".")."'>".$_FILES['attach']['name']."</a>";

						//Send an Email

						$emailObj->sendUpdateAttachmentEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$link,'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$model->lead_id.'</a>');

						

					}

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Attachment in ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

					return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			

			// Add Notes

			if(!empty($_REQUEST['add_note_model'])){

				$nid = NoteModel::noteInsert($_REQUEST['id'],$this->entity_type);

				if($nid){

					setcookie('inserted_notes'.$_REQUEST['id'],true,time()+7200);

				}

				//Send an Email

				$emailObj->sendNoteEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName()." <br>".$_REQUEST['notes'],'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$model->lead_id.'</a>');

				

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Note into ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

				return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			

			// Update Notes

			if(!empty($_REQUEST['edit_note_model'])){

				$nid = NoteModel::noteEdit();

				//Send an Email

				$emailObj->sendNoteUpdateEmailTemplate($this->getUserEmail($model->assigned_user_id),$this->getUserFullName($model->assigned_user_id),$this->getLoggedUserFullName()." <br>".$_REQUEST['notes'],'<a href="'.$_SESSION['base_url'].$this->view_page.$model->id.'">'.$model->lead_id.'</a>');

				

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Note in ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

				return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			// Add Lead Timing

			if(!empty($_REQUEST['lead_timing_add'])){

				$this->leadTimeAdd($_REQUEST['notes'],'MANUAL',$_REQUEST['start_time'],$_REQUEST['end_time']);

				// Update Lead Spend Time

				$this->updateLeadSpendTime($_REQUEST['id']);

				//Add History 

				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Lead Work Timing into ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

				return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			if(!empty($_REQUEST['time_entry_id'])){

				$timeEntryModel = TimeEntry::findOne($_REQUEST['time_entry_id']);

			}

			// Edit  Timing

			if(!empty($_REQUEST['lead_timing_edit'])){

				$this->leadTimeEdit($_REQUEST['notes'],$_REQUEST['time_entry_id'],$_REQUEST['start_time'],$_REQUEST['end_time']);

				// Update  Spend Time

				$this->updateLeadSpendTime($_REQUEST['id']);

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,'Updated Lead Work Timing in ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

				return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			// Edit Lead LeadTimeEditApproved

			if(!empty($_REQUEST['appid'])){

				$this->leadTimeEditApproved($_REQUEST['appid']);

				return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			// Delete Lead Attachment

			if(!empty($_REQUEST['time_del_id'])){

					$Attachmodel = TimeEntry::findOne($_REQUEST['time_del_id'])->delete();

					// Update  Spend Time

					$this->updateLeadSpendTime($_REQUEST['id']);

					//Add History

				HistoryModel::historyInsert($this->entity_type,$model->id,'Deleted Lead Work Timing from  ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

					return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			if(!empty($_REQUEST['starttime'])){

				date_default_timezone_set('Asia/Kolkata');

				setcookie('lead_start_time',date('Y-m-d H:i:s'),time()+7200);

				setcookie('leadStartedId',$_REQUEST['id'],time()+7200);

				 return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

			if(!empty($_REQUEST['leadnotes']) && !empty($_COOKIE['lead_start_time'])){

				date_default_timezone_set('Asia/Kolkata');

				$start_time=$_COOKIE['lead_start_time'];

				$end_time = date('Y-m-d H:i:s');

				// Add Time

				$this->leadTimeAdd($_REQUEST['leadnotes'],'AUTO',$start_time,$end_time);

				setcookie('lead_start_time',date('Y-m-d H:i:s'),time()-3600);

				setcookie('leadStartedId',$_REQUEST['id'],time()-3600);

				// Update Lead Spend Time

				$this->updateLeadSpendTime($_REQUEST['id']);

				//Add History For Lead

				HistoryModel::historyInsert($this->entity_type,$model->id,'Added Note into ( <a href="index.php'.$this->view_page.$model->id.'">'.$model->lead_id.'</a>)');

				return $this->redirect(['lead-view', 'id' => $_REQUEST['id']]);

			}

            return $this->render('lead-view', [

                'model' => $model,

				'attachModel'=>$attachModelR,

				'noteModel'=>$noteModelR,

				'sub_lead'=>$sub_lead,

				'timeEntryModel'=>$timeEntryModel,

            ]);

        }

    }

	public function actionAjaxLead($id){

		$start_time=!empty($_REQUEST['start_time'])?$_REQUEST['start_time']:'';

		$eid=!empty($_REQUEST['eid'])?$_REQUEST['eid']:'';

		if($eid){

			$leadModel = TimeEntry::find()->where("id != $eid and entity_id=$id and entity_type='lead' and start_time<='$start_time' and end_time >='$start_time'")->one();

		}else{

		$leadModel = TimeEntry::find()->where("entity_id=$id and entity_type='lead' and start_time<='$start_time' and end_time >='$start_time'")->one();	

		}

		 return $this->renderPartial('ajax-lead', [

                'name' => $leadModel->id,

            ]);

	}

	

	public function actionAjaxLeadTimeDateValidation(){

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

		 return $this->renderPartial('ajax-lead-time-date-validation', [

                'error' =>$error,

            ]);

	}

	public function getSpentTime($enity_id,$user_id){

		$leadModel = TimeEntry::find()->where("entity_id=$enity_id and entity_type='".$this->entity_type."'")->asArray()->all();

					

		$spend_t=0;

		$dotNumTot=0;

		$solidNumTot=0;

		foreach($leadModel as $trow1){

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

	public function actionLeadClosedReports(){

		date_default_timezone_set('Asia/Kolkata');

		$start_date=$_REQUEST['start_date'];

		$date=$_REQUEST['date']?$_REQUEST['date']:'this_month';

		$end_date=$_REQUEST['end_date'];

		$weekStartDate = date('Y-m-d',strtotime('last monday'));

		$lastMonthFirstDate = date('Y-m-d',strtotime('first day of last month'));

		$lastMonthLastDate = date('Y-m-d',strtotime('last day of last month'));

		$monthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$curdate=date('Y-m-d');

		$filter=array('today','yesterday');

		if(!in_array($date,$filter)){

		

			$sql="SELECT lot_user.first_name,lot_user.last_name,count(lot_lead.id) counts,date(lot_lead.actual_end_datetime) actual_end_datetime FROM `lot_lead`,lot_user WHERE lot_lead.assigned_user_id=lot_user.id and lead_status_id=2 ";

			

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

			$sql .="  GROUP BY date(actual_end_datetime),lot_lead.assigned_user_id ORDER by date(actual_end_datetime)";

			$connection = \Yii::$app->db;

			$command=$connection->createCommand($sql);

			$dataReader=$command->queryAll();

		}else{

			$date_value=$date=='today'?date('Y-m-d'):date('Y-m-d',strtotime("-1 days"));

			

			$sql="SELECT lot_user.first_name,

						lot_user.last_name,lot_user.id uid,

						DATE_FORMAT(lot_lead.actual_end_datetime,'%H') actual_end_datetime,

						lot_lead.assigned_user_id,lot_lead.id tid,count(lot_lead.id) leadcount FROM `lot_lead`,lot_user WHERE lot_lead.assigned_user_id=lot_user.id and lead_status_id=2  and  date(actual_end_datetime) = '$date_value'  GROUP BY DATE_FORMAT(lot_lead.actual_end_datetime,'%H'),lot_lead.assigned_user_id ORDER by assigned_user_id,date(actual_end_datetime)";

			$connection = \Yii::$app->db;

			$command=$connection->createCommand($sql);

			$dataReader=$command->queryAll();

			}

			return $this->render('lead-closed-reports', [

				'dataProvider' => $dataReader,

			]);

		

	}

	public function getNeedActions($project_id){

		$leadModel = Lead::find()->joinWith('user')->where("project_id=$project_id and lead_status_id=5")->orderBy('actual_end_datetime')->asArray()->all();

		return $leadModel;

	}

	public function getInprocessLeads($project_id){

		$leadModel = Lead::find()->joinWith('user')->where("project_id=$project_id and lead_status_id=1")->orderBy('actual_end_datetime')->asArray()->all();

		return $leadModel;

	}

	public function getWeakClosedLeads($project_id){

		date_default_timezone_set('Asia/Kolkata');

		$weekStartDate = date('Y-m-d',strtotime('last monday'));

		$curdate=date('Y-m-d');

		$leadModel = Lead::find()->joinWith('user')->where("project_id=$project_id and lead_status_id=2 and date(actual_end_datetime) >='$weekStartDate' and date(actual_end_datetime) <='$curdate'")->orderBy('actual_end_datetime')->asArray()->all();

		

		return $leadModel;

	}

	public function getMonthClosedLeads($project_id){

		date_default_timezone_set('Asia/Kolkata');

		$monthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$curdate=date('Y-m-d');

		$leadModel = Lead::find()->joinWith('user')->where("project_id=$project_id and lead_status_id=2 and date(actual_end_datetime) >='$monthFirstDate' and date(actual_end_datetime) <='$curdate'")->orderBy('actual_end_datetime')->asArray()->all();

		return $leadModel;

	}

	public function getTotalUserSpentTime($uid,$date){

	  $sql="select lot_time_entry.* from lot_time_entry,lot_lead where lot_lead.assigned_user_id='$uid' and lot_lead.id=lot_time_entry.entity_id and date(start_time)='$date'";

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

		$start_date=$_REQUEST['start_date'];

		$date=$_REQUEST['date']?$_REQUEST['date']:'this_month';

		$end_date=$_REQUEST['end_date'];

		$weekStartDate = date('Y-m-d',strtotime('last monday'));

		$lastMonthFirstDate = date('Y-m-d',strtotime('first day of last month'));

		$lastMonthLastDate = date('Y-m-d',strtotime('last day of last month'));

		$monthFirstDate = date('Y-m-d',strtotime('first day of this month'));

		$lastWeekStartDate=date('Y-m-d',strtotime(date('Y-m-d',strtotime('last monday'))."- 7 days"));

		$lastWeekEndDate=date('Y-m-d',strtotime('last sunday'));

		$curdate=date('Y-m-d');

		$sql="SELECT lot_customer.id cid,lot_user.first_name,lot_lead.assigned_user_id,lot_customer.customer_name,lot_lead.id tid,lot_lead.lead_id, lot_lead.lead_title,lot_lead.actual_end_datetime,lot_time_entry.* FROM `lot_customer`,lot_lead,lot_time_entry,lot_user WHERE lot_user.id=lot_lead.assigned_user_id and lot_customer.id=lot_lead.customer_id and lot_lead.id=lot_time_entry.entity_id and lot_time_entry.entity_type='lead' ";

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

		$sql.="  ORDER by  date(end_time), lead_title";

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

		return $leadModel;

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

	public function actionMyCalendar(){

		$sql = "SELECT *, date(expected_start_datetime)   expected_start_datetime,IF(lead_status_id=2,date(actual_end_datetime),date(expected_end_datetime))  expected_end_datetime FROM lot_lead  where assigned_user_id = '".Yii::$app->user->identity->id."' limit 120";

			$connection = \Yii::$app->db;

			$command=$connection->createCommand($sql);

			$dataReader=$command->queryAll();

			//echo count($dataReader);

			return $this->render('my-calendar', [

				'dataProvider' => $dataReader,

			]);

	}

	

	public function actionNeedActions(){

		$searchModel = new LeadSearch;

        $dataProvider = $searchModel->searchNeedActions(Yii::$app->request->getQueryParams());

        return $this->render('need-actions', [

            'dataProvider' => $dataProvider,

            'searchModel' => $searchModel,

        ]);

	}

	public function actionMyLeads(){

		if(!empty($_REQUEST['multiple_del'])){

			$rows=$_REQUEST['selection'];

			for($i=0;$i<count($rows);$i++){

				$this->findModel($rows[$i])->delete();

			}

		}

		$searchModel = new LeadSearch;

        $dataProvider = $searchModel->searchMyLeads(Yii::$app->request->getQueryParams());

        return $this->render('my-leads', [

            'dataProvider' => $dataProvider,

            'searchModel' => $searchModel,

        ]);

	}

	public function actionLeadAllReports(){

			

            return $this->render('lead-all-reports');

		

	}

	public function actionLeadAssignmentReport(){

			

            return $this->render('lead-assignment-report');

		

	}

    /**

     * Deletes an existing Lead model.

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

     * Finds the Lead model based on its primary key value.

     * If the model is not found, a 404 HTTP exception will be thrown.

     * @param integer $id

     * @return Lead the loaded model

     * @throws NotFoundHttpException if the model cannot be found

     */

    protected function findModel($id)

    {

        if (($model = Lead::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }

    }

}


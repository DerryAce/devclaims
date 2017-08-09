<?php

use livefactory\modules\pmt\controllers\ProjectController;

use livefactory\models\search\CommonModel;

use yii\helpers\Html;

use livefactory\models\search\Project as ProjectSearch;

use livefactory\models\FileModel;

/**

 * @var yii\web\View $this

 * @var common\models\Project $model

 */



$this->title = Yii::t('app', 'Update Claim'). ' ' . $model->project_name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Claims'), 'url' => ['index']];

//$this->params['breadcrumbs'][] = ['label' => $model->project_name, 'url' => ['view', 'id' => $model->id]];

$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$user_ids = array($model->project_owner,1);

if(in_array(Yii::$app->user->identity->id,$user_ids)){

		$disabled=0;

	}else{

			$disabled=1;

	}

?>

<script src="../include/jquery.js"></script>

<script src="../include/ckeditor/ckeditor.js"></script>

<script src="../include/bootstrap-datetimepicker.js"></script>



<style>	

.cke_contents{max-height:250px}

.slider .tooltip.top {

    margin-top: -36px;

    z-index: 100;

}

.close {

    color: #000000;

    float: right;

    font-size: 18px;

    font-weight: bold;

    line-height: 1;

    opacity: 0.2;

    text-shadow: 0 1px 0 #ffffff;

}
/*.nav-tabs > li > a{
	font-size:11px
}*/
</style>

<script type="text/javascript">

function Add_Error(obj,msg){

	 $(obj).parents('.form-group').addClass('has-error');

	 $(obj).parents('.form-group').append('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');

	 return true;

}

function Remove_Error(obj){

	$(obj).parents('.form-group').removeClass('has-error');

	$(obj).parents('.form-group').children('.error').remove();

	return false;

}

function Add_ErrorTag(obj,msg){

	obj.css({'border':'1px solid #D16E6C'});

	

	obj.after('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');

	 return true;

}

function Remove_ErrorTag(obj){

	obj.removeAttr('style').next('.error').remove();

	return false;

}

  

   

$(document).ready(function(){


    $('.tabbable').appendTo('#w0');

    //console.log($('a[data-toggle="tab"]:first').tab('show'))

    $('a[data-toggle="tab"]').on('shown.bs.tab', function () {

        //save the latest tab; use cookies if you like 'em better:

        localStorage.setItem('lastTab_leadview', $(this).attr('href'));

    });



    //go to the latest tab, if it exists:

    var lastTab_leadview = localStorage.getItem('lastTab_leadview');

    if ($('a[href=' + lastTab_leadview + ']').length > 0) {

        $('a[href=' + lastTab_leadview + ']').tab('show');

    }

    else

    {

        // Set the first tab if cookie do not exist

        $('a[data-toggle="tab"]:first').tab('show');

    }

	if('<?=!empty($_REQUEST['attach_update'])?$_REQUEST['attach_update']:''?>' !=''){

		$('.popup').modal('show');

		

	}

	if('<?=!empty($_GET['note_id'])?$_GET['note_id']:''?>' !=''){

		$('.note_edit').modal('show');

	}

	$('#project-expected_start_date-disp').val($('#project-expected_start_date').val()==''?'':'<?=date('D j M Y',strtotime($model->expected_start_date))?>');

	$('#project-expected_end_date-disp').val($('#project-expected_end_date').val()==''?'':'<?=date('D j M Y',strtotime($model->expected_end_date))?>');

	$('#project-actual_start_date-disp').val($('#project-actual_start_date').val()==''?'':'<?=date('D j M Y',strtotime($model->actual_start_date))?>');

	$('#project-actual_end_date-disp').val($('#project-actual_end_date').val()==''?'':'<?=date('D j M Y',strtotime($model->actual_end_date))?>');

	// Disabled Customer Field
	if('<?=$model->customer_id?>' !='')
	$('#project-customer_id').attr('disabled','disabled');

	if('<?=$disabled?>'=='1'){

		$('#project-project_owner').attr('disabled','disabled');

	}

	if('<?=!empty($_GET['tasktab'])?$_GET['tasktab']:''?>' !=''){

		//alert('ddd');

		$('.tasktab').tab('show');	

	}

	if('<?=!empty($_GET['joined_user'])?$_GET['joined_user']:''?>' !=''){

		$('.joined_user').tab('show');	

	}

	CKEDITOR.config.autoParagraph = false;

	$('#w32 #task-assigned_user_id').load('index.php?r=pmt/task/ajax-project-users&project_id=<?=$model->id?>');
	$('#task-assigned_user_id').load('index.php?r=pmt/task/ajax-project-users&project_id=<?=$model->id?>');
	$('#defect-assigned_user_id').load('index.php?r=pmt/defect/ajax-project-users&project_id=<?=$model->id?>');

});



</script>

 <div class="wrapper wrapper-content animated fadeIn">

        <div class="row">

            <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

    					<h5> <?=Yii::t('app', 'Project')?> - <?=$model->project_name ?></h5>



						<div class="ibox-tools">

							<a href="index.php?r=customer/customer/customer-view&id=<?=$model->customer_id?>" class="btn btn-xs btn-info" style="color:#fff;"><span class="glyphicon glyphicon-new-window"></span> <?=Yii::t('app', 'View Client')?></a>



						    <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                           

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

			<!--

        	<div class="pull-right">

            	<a href="index.php?r=customer/customer/customer-view&id=<?=$model->customer_id?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-new-window"></span> View Customer</a>&nbsp;

                <a class="close" href="index.php?r=pmt/project/index" >

                	<span class="glyphicon glyphicon-remove"></span>

                </a>

            </div>

			-->

    </div>

  					 <div class="ibox-content">

        <div class="project-update">

        

            <?= $this->render('_form', [

                'model' => $model,

            ]) ?>

        

        </div>

        <div class="tabbable">

                <ul class="nav nav-tabs">

                <li class="active"><a href="#desc" role="tab" data-toggle="tab"> <?=Yii::t('app', 'UTMOST Comments')?></a></li>

                <li><a href="#attachments" role="tab" data-toggle="tab"><?=Yii::t('app', 'Attachments')?>

                 <span class="badge"> <?= FileModel::getAttachmentCount('project',$model->id)?></span>

                </a></li>

                <li><a href="#notes" role="tab" data-toggle="tab"><?=Yii::t('app', 'Notes')?></a></li>

                <li><a href="#assign_history" role="tab" data-toggle="tab"><?=Yii::t('app', 'Assignment History')?></a></li>

                <li><a href="#tasktab" class="tasktab" role="tab" data-toggle="tab"><?=Yii::t('app', 'Incidents')?></a></li>
                
                <!--<li><a href="#defects" role="tab" data-toggle="tab"><?=Yii::t('app', 'Defects')?></a></li>-->

                <li><a href="#user" class="joined_user" role="tab" data-toggle="tab"><?=Yii::t('app', 'Users')?></a></li>

                <!--<li><a href="#history" role="tab" data-toggle="tab">History</a></li>-->

                <li><a href="#history" role="tab" data-toggle="tab"><?=Yii::t('app', 'Activity')?></a></li>

                </ul>

            

            <div class="tab-content">

            <div class="tab-pane  active" id="desc"> 

            <br/>

            <?php

            echo '<div class="row">

                            <div class="col-sm-12">

                                <div class="form-group">

                                <label class="control-label" for="lname">'.Yii::t('app', 'Comments').':

            

                                </label>

                                <div class="controls">

                                  <textarea class="form-control input-sm ckeditor" name="UTMOST[project_description]" id="project_description" rows="8" style="width:100%">'.$model->project_description.'</textarea>

                                </div>

                            </div>

                            </div>

                        </div>';

            ?>

            </div>

            <div class="tab-pane" id="attachments"> 

            <br/>

                       <?php

                                        

                                        $searchModelAttch = new CommonModel();

                                        $dataProviderAttach = $searchModelAttch->searchAttachments( Yii::$app->request->getQueryParams (), $model->id,'project' );

                                        

                                        echo Yii::$app->controller->renderPartial("../../../liveobjects/views/file/attachment-module/attachments", [ 

                                                'dataProviderAttach' => $dataProviderAttach,

                                                'searchModelAttch' => $searchModelAttch,

                                                'task_id'=>$model->id

                                        ] );

                                        

                                        ?>

            </div>

            <div class="tab-pane fade" id="notes"> 

            <br/>	

                         <?php

                                        

                                        $searchModelNotes = new CommonModel();

                                        $dataProviderNotes = $searchModelNotes->searchNotes( Yii::$app->request->getQueryParams (), $model->id ,'project');

                                        

                                        echo Yii::$app->controller->renderPartial("../../../liveobjects/views/note/notes-module/notes", [ 

                                                'dataProviderNotes' => $dataProviderNotes,

                                                'searchModelNotes' => $searchModelNotes

                                        ] );

                                        

                                        ?>

            </div>

            <div class="tab-pane fade" id="history"> 

            <br/>			

                      <?php

                                        

                                        $searchModelHistory = new CommonModel();

                                        $dataProviderHistory = $searchModelHistory->searchHistory( Yii::$app->request->getQueryParams (), $model->id,'project' );

                                        

                                        echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/histories", [ 

                                                'dataProviderHistory' => $dataProviderHistory,

                                                'searchModelHistory' => $searchModelHistory 

                                        ] );

                                        

                                        ?>

            </div>

            <div class="tab-pane fade" id="assign_history"> 

            <br/>			

                     <?php

                                        

                        $searchModelAssHis = new CommonModel();

                        $dataProviderAssHis = $searchModelAssHis->searchAssignedHistory( Yii::$app->request->getQueryParams (), $model->id,'project' );

                        

                        echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/assigned_histories", [ 

                                'dataProviderAssHis' => $dataProviderAssHis,

                                'searchModelAssHis' => $searchModelAssHis 

                        ] );

                        

                        ?>     

            </div>

            <div class="tab-pane fade" id="user"> 

            <br/>			

                    <?php

                                        

                        $searchModelUser = new ProjectSearch();

                        $dataProviderUser = $searchModelUser->searchProjectUser( Yii::$app->request->getQueryParams (), $model->id );

                        $_SESSION['project_user_id']=$model->project_owner;

                        echo Yii::$app->controller->renderPartial("user_tab", [ 

                                'dataProviderUser' => $dataProviderUser,

                                'searchModelUser' => $searchModelUser ,

								'project_user_id'=>$model->project_owner

                        ] );

                        

                        ?>      

            </div>

            <div class="tab-pane fade" id="tasktab"> 

            <br/>			

                    <?php

                                        

                        $searchModelTask = new ProjectSearch();

                        $dataProviderTask = $searchModelTask->searchTask( Yii::$app->request->getQueryParams (), $model->id );

                        

                        echo Yii::$app->controller->renderPartial("task_tab", [ 

                                'dataProviderTask' => $dataProviderTask,

                                'searchModelTask' => $searchModelTask 

                        ] );

                        

                        ?>      

            </div>
            
            <!--<div class="tab-pane fade" id="defects"> 

            <br/>			

                    <?php

                                        

                        $searchModelDefect = new ProjectSearch();

                        $dataProviderDefect = $searchModelDefect->searchDefect( Yii::$app->request->getQueryParams (), $model->id );

                        

                        echo Yii::$app->controller->renderPartial("defect_tab", [ 

                                'dataProviderDefect' => $dataProviderDefect,

                                'searchModelDefect' => $searchModelDefect 

                        ] );

                        

                        ?>      

            </div>-->

            <div class="tab-pane fade" id="activity"> 

            <br/>			

                    <?php

                                        

                        $searchModelActivity = new CommonModel();

                        $dataProviderActivity = $searchModelActivity->searchActivity( Yii::$app->request->getQueryParams (), $model->id,'project' );

                        

                        echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/activity_tab", [ 

                                'dataProviderActivity' => $dataProviderActivity,

                                'searchModelActivity' => $searchModelActivity 

                        ] );

                        

                        ?>      

            </div>

            <input type="hidden" name="old_owner" value="<?=$model->project_owner?>">

            </div>

            <?php

            echo Html::submitButton ( $model->isNewRecord ?Yii::t('app', 'Create')  : Yii::t('app', 'Update'), [ 

            

                                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-sm  update_task' 

            

                            ] );?> <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.add-notes-modal').modal('show');"><i class="glyphicon glyphicon-comment"></i> <?=Yii::t('app', 'New Note')?> </a>

                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.savepopup').modal('show');"><i class="glyphicon glyphicon-save"></i> <?=Yii::t('app', 'New Attachment')?> </a>

                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.taskae').modal('show');"><i class="fa fa-edit"></i> <?=Yii::t('app', 'New Complaint')?></a>
                            
                            <a class="btn btn-success btn-sm" onclick="$('.defectae').modal('show');" href="javascript:void(0)">
<i class="fa fa-bug"></i> <?=Yii::t('app', 'New Defect')?></a>

                            <?php if(!$disabled){?>

                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.exist_users').modal('show');"><i class="glyphicon glyphicon-user"></i> <?=Yii::t('app', 'Add User')?></a>

                            <?php } ?>

                             

                            

                            

                            <?php

            

                            //ActiveForm::end ();

                            echo "</form>";

            ?>

            </div>

    </div>

   				</div>

           </div>

       </div>

</div>

<?php

	$email=ProjectController::getUserEmail($model->project_owner);

	include_once(__DIR__ .'/../../../liveobjects/views/file/attachment-module/attachmentae.php');

	include_once(__DIR__ .'/../../../liveobjects/views/note/notes-module/noteae.php');

	include_once('taskae.php');
	
	include_once('defectae.php');

	include_once('join_user.php');

?>
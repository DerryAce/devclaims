<?php

use livefactory\modules\pmt\controllers\DefectController;

use livefactory\models\search\CommonModel;

use yii\helpers\Html;

use yii\helpers\ArrayHelper;

use livefactory\models\FileModel;

use kartik\widgets\ActiveForm;



use dosamigos\ckeditor\CKEditor;

use kartik\builder\Form;

use livefactory\models\search\Defect as DefectSearch;

/**

 * @var yii\web\View $this

 * @var common\models\Defect $model

 */





$this->title = Yii::t('app', 'Update Defect') . ' ' . $model->defect_name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Defects'), 'url' => ['index']];

//$this->params['breadcrumbs'][] = ['label' => $model->defect_id, 'url' => ['view', 'id' => $model->id]];

$this->params['breadcrumbs'][] = Yii::t('app', 'Update');


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

	CKEDITOR.config.autoParagraph = false;

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

	if('<?=!empty($_GET['time_entry_id'])?$_GET['time_entry_id']:''?>' !=''){

		$('.defect_timing').modal('show');

	}

	//Sub-Defect Script

	$(document).on('click','.defectScript',function(){

			 $('.form_datetime1').datetimepicker({

				format: 'D d M yyyy hh:ii:ss'

			});

			$('.form_datetime2').datetimepicker({

				format: 'D d M yyyy hh:ii:ss'

			});

			$('.form_datetime3').datetimepicker({

				format: 'D d M yyyy hh:ii:ss'

			});

			$('.form_datetime4').datetimepicker({

				format: 'D d M yyyy hh:ii:ss'

			});

	})

	 $('.subdefect_insert').click(function(event){

		 Remove_Error($('.expected_end_datetime'));

		 Remove_Error($('.expected_start_datetime'));

		if($('.expected_start_datetime').val()==''){

			 Add_Error($('.expected_start_datetime'),'<?=Yii::t ('app','This Field is Required!')?>');

			 event.preventDefault();

		}else{

			Remove_Error($('.expected_start_datetime'));

		}

		if($('.expected_end_datetime').val()==''){

			 Add_Error($('.expected_end_datetime'),'<?=Yii::t ('app','This Field is Required!')?>');

			 event.preventDefault();

		}else{

			Remove_Error($('.expected_end_datetime'));

		}

	 })

	$('#defect-expected_start_datetime-disp').val($('#defect-expected_start_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->expected_start_datetime))?>');

	$('#defect-expected_end_datetime-disp').val($('#defect-expected_end_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->expected_end_datetime))?>');

	$('#defect-actual_start_datetime-disp').val($('#defect-actual_start_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->actual_start_datetime))?>');

	$('#defect-actual_end_datetime-disp').val($('#defect-actual_end_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->actual_end_datetime))?>');

	

$('#defect-actual_end_datetime').change(function(){

	setTimeout(function(){

	if($('#defect-defect_status_id').val() ==2){

		var actual_start = $('#defect-actual_start_datetime').val();

		var actual_end = $('#defect-actual_end_datetime').val();

		var startTime = new Date(actual_start);

		var endTime = new Date(actual_end);

		//alert($('#defect-actual_end_datetime').val());

	//	alert(startTime>endTime);

		Remove_Error($('#defect-actual_end_datetime-disp'));

		if(startTime>endTime){

			 Add_Error($('#defect-actual_end_datetime-disp'),'<?=Yii::t ('app','Start Time Should be Less than Completion Time!')?>');

			 $('.update_defect').attr('disabled',true);

		}else{

			Remove_Error($('#defect-actual_end_datetime-disp'));

			  $('.update_defect').removeAttr('disabled');

		}

	}

	},1000)

})

$('#defect-defect_status_id').change(function(){

	if($('#defect-defect_status_id').val() ==2){

		if('<?=!empty($_COOKIE['inserted_notes'.$model->id])?$_COOKIE['inserted_notes'.$model->id]:''?>' != '1'){

			$('.add-notes-modal').modal('show');

		}

	}

})

$('.update_defect').click(function(event){

	if($('#defect-defect_status_id').val() ==2){

			if('<?=!empty($_COOKIE['inserted_notes'.$model->id])?$_COOKIE['inserted_notes'.$model->id]:''?>' != '1'){

				alert('<?=Yii::t ('app','Please Add Notes!')?>');

				$('.add-notes-modal').modal('show');

				event.preventDefault();

			}else{

				

				error='';

				Remove_Error($('#defect-actual_start_datetime-disp'));

				Remove_Error($('#defect-actual_end_datetime-disp'));

				

				var actual_start = $('#defect-actual_start_datetime').val();

				var actual_end = $('#defect-actual_end_datetime').val();

				var startTime = new Date(actual_start);

				var endTime = new Date(actual_end);

				 //alert($('#defect-actual_end_datetime').val());

	            // alert(startTime>endTime);

				if(startTime>endTime){

					 error+=Add_Error($('#defect-actual_end_datetime-disp'),'<?=Yii::t ('app','Start Time Should be Less than Completion Time')?>');

				}else{

					Remove_Error($('#defect-actual_end_datetime-disp'));

				}

				if($('#defect-actual_start_datetime-disp').val() ==''){

					error+=Add_Error($('#defect-actual_start_datetime-disp'),'<?=Yii::t ('app','This field Required!')?>');

				}else{

					Remove_Error($('#defect-actual_start_datetime-disp'));

				}

				if($('#defect-actual_start_datetime-disp').val() ==''){

					error+=Add_Error($('#defect-actual_end_datetime-disp'),'<?=Yii::t ('app','This field Required!')?>');

				}else{

					Remove_Error($('#defect-actual_end_datetime-disp'));

				}

				if(error !=''){

					event.preventDefault();

					return false;

				}else{

					return true;

				}

			}

		}else{

			return true;	

		}

	})
	if('<?=$model->project_id?>' !='')
	$('#defect-project_id').attr('disabled','disabled');

	$('.stopTime').click(function(){

		$('.defectnotes').modal('show');

	})

	$('#defect-project_id').change(function(){

	 $.post('index.php?r=pmt/defect/ajax-project-users&project_id='+$(this).val(),function(r){

		$('#defect-assigned_user_id').html(r) ;

	 })

   })

   $('#defect-assigned_user_id').load('index.php?r=pmt/defect/ajax-project-users&project_id=<?=$model->project_id?>&user_id=<?=$model->assigned_user_id?>');

   $('#w32 #defect-assigned_user_id').load('index.php?r=pmt/defect/ajax-project-users&project_id=<?=$model->project_id?>');

});
if('<?=!empty($_COOKIE['defect_start_time'])?$_COOKIE['defect_start_time']:''?>' !=''){
	setInterval(function(){

		$.post('<?=str_replace('index.php','',$_SESSION['base_url'])?>ajax_clock2.php',function(result){

			var alink ='<i class="glyphicon glyphicon-time"></i> Stop Timer '+result;

				$(".stopTime").html(alink);	

			})

		},1000)
}

</script>
<div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5><?= Yii::t('app', 'Defect View')?> - <small class="m-l-sm"><?= $model->defect_id ?></small></h5>

                        <div class="ibox-tools">
							<?php if($model->parent_id){?>

            	<a href="index.php?r=pmt/defect/defect-view&id=<?=$model->parent_id?>" class="btn btn-xs btn-info" style="color:#fff;"><span class="glyphicon glyphicon-new-window"></span> <?= Yii::t('app', 'View Parent Defect')?></a>&nbsp;

                <?php } ?>

                <a href="index.php?r=pmt/project/project-view&id=<?=$model->project_id?>" class="btn btn-xs btn-info" style="color:#fff;"><span class="glyphicon glyphicon-new-window"></span> <?= Yii::t('app', 'View Project')?></a>&nbsp;
						    <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

                    </div>

                    <div class="ibox-content">
					  <div class="defect-update">



		<?= $this->render('_form', [

            'model' => $model,

        ]) ?>

    

    </div>
					 <div class="tabbable">

        <ul class="nav nav-tabs">

        <li class="active"><a href="#desc" role="tab" data-toggle="tab"><?= Yii::t('app', 'Defect Description')?></a></li>

        <li><a href="#attachments" role="tab" data-toggle="tab"><?= Yii::t('app', 'Attachments')?>	

           

            <span class="badge"> <?= FileModel::getAttachmentCount('defect',$model->id)?></span>

        </a></li>

        <li><a href="#notes" role="tab" data-toggle="tab"><?= Yii::t('app', 'Notes')?></a></li>

        <li><a href="#subdefecttab" role="tab" data-toggle="tab"><?= Yii::t('app', 'Sub Defects')?>

        	<span class="badge"><?= DefectSearch::getSubDefectCount($model->id)?></span>

        	 

        </a></li>

        <li><a href="#timesheet" role="tab" data-toggle="tab"><?= Yii::t('app', 'Timesheet')?></a></li>

        <li><a href="#assign_history" role="tab" data-toggle="tab"><?= Yii::t('app', 'Assignment History')?></a></li>

        <!--<li><a href="#history" role="tab" data-toggle="tab">History</a></li>-->

        <li><a href="#history" role="tab" data-toggle="tab"><?= Yii::t('app', 'Activity')?></a></li>

        </ul>

    

    <div class="tab-content">

    <div class="tab-pane  active" id="desc"> 

    <br/>

    <?php

    echo '<div class="row">

                    <div class="col-sm-12">

                        <div class="form-group">

                        <label class="control-label" for="lname">'.Yii::t('app', 'Description').':

    

                        </label>

                        <div class="controls">

                          <textarea class="form-control input-sm ckeditor" name="Defect[defect_description]" id="defect_description" rows="8" style="width:100%">'.$model->defect_description.'</textarea>

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

                                $dataProviderAttach = $searchModelAttch->searchAttachments( Yii::$app->request->getQueryParams (), $model->id,'defect' );

                                

                                echo Yii::$app->controller->renderPartial("../../../liveobjects/views/file/attachment-module/attachments", [ 

                                        'dataProviderAttach' => $dataProviderAttach,

                                        'searchModelAttch' => $searchModelAttch,

                                        'defect_id'=>$model->id

                                ] );

                                

                                ?>

    </div>

    <div class="tab-pane fade" id="notes"> 

    <br/>	

                 <?php

                                

                                $searchModelNotes = new CommonModel();

                                $dataProviderNotes = $searchModelNotes->searchNotes( Yii::$app->request->getQueryParams (), $model->id,'defect' );

                                

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

                                $dataProviderHistory = $searchModelHistory->searchHistory( Yii::$app->request->getQueryParams (), $model->id,'defect' );

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

                $dataProviderAssHis = $searchModelAssHis->searchAssignedHistory( Yii::$app->request->getQueryParams (), $model->id,'defect'  );

                

                echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/assigned_histories", [ 

                        'dataProviderAssHis' => $dataProviderAssHis,

                        'searchModelAssHis' => $searchModelAssHis 

                ] );

                

                ?>     

    </div>

    <div class="tab-pane fade" id="timesheet"> 

    <br/>			

            <?php

                                

                $searchModelDefectTime = new DefectSearch();

                $dataProviderDefectTime = $searchModelDefectTime->searchDefectTime( Yii::$app->request->getQueryParams (), $model->id,'defect'  );

				

                $_SESSION['project_id']=$model->project_id ;

                echo Yii::$app->controller->renderPartial("defect_timing_tab", [ 

                        'dataProviderDefectTime' => $dataProviderDefectTime,

                        'searchModelDefectTime' => $searchModelDefectTime,

						'assigned_user_id'=>$model->assigned_user_id,

                ] );

                

                ?>      

    </div>

    <div class="tab-pane fade" id="subdefecttab"> 

    <br/>			

            <?php

                                

                $searchModelDefect = new DefectSearch();

                $dataProviderDefect = $searchModelDefect->searchSubDefect( Yii::$app->request->getQueryParams (), $model->id );

                

                echo Yii::$app->controller->renderPartial("sub_defect_tab", [ 

                        'dataProviderDefect' => $dataProviderDefect,

                        'searchModelDefect' => $searchModelDefect 

                ] );

                

                ?>      

    </div>

    <div class="tab-pane fade" id="activity"> 

    <br/>			

            <?php

                                

                $searchModelActivity = new CommonModel();

                $dataProviderActivity = $searchModelActivity->searchActivity( Yii::$app->request->getQueryParams (), $model->id,'defect' );

                

                echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/activity_tab", [ 

                        'dataProviderActivity' => $dataProviderActivity,

                        'searchModelActivity' => $searchModelActivity 

                ] );

                

                ?>      

    </div>

    <input type="hidden" name="old_owner" value="<?=$model->assigned_user_id?>">

    <input type="hidden" name="old_defect_priority_id" value="<?=$model->defect_priority_id?>">

    <input type="hidden" name="old_defect_status_id" value="<?=$model->defect_status_id?>">

    </div>

    <?php

    echo Html::submitButton ( $model->isNewRecord ? Yii::t('app', 'Create' ): Yii::t('app', 'Update'), [ 

    

                            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-sm  update_defect' 

    

                    ] );?> <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.add-notes-modal').modal('show');"><i class="glyphicon glyphicon-comment"></i> <?= Yii::t('app', 'New Note')?></a>

                    <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.savepopup').modal('show');"><i class="glyphicon glyphicon-save"></i> <?= Yii::t('app', 'New Attachment')?></a>

                    <a href="javascript:void(0)" class="btn btn-success btn-sm defectScript" onClick="$('.defectae').modal('show');"><i class="glyphicon glyphicon-tag"></i> <?= Yii::t('app', 'Add Subdefect')?></a>

                     

                     <?php
				if(Yii::$app->user->identity->id == $model->assigned_user_id || Yii::$app->user->identity->user_role_id=='1'){
                    if(!empty($_COOKIE['defect_start_time'])){

                        if($_COOKIE['defectStartedId']==$_GET['id']){

                    ?>

                    <a href="javascript:void(0)" class="btn btn-sm   btn-danger <?=$_COOKIE['defect_start_time']?'':'hideBtn'?> stopTime"  data-toggle="modal"><i class="glyphicon glyphicon-time"></i> <?= Yii::t('app', 'End Timer')?></a>

                    <?php 

                        }

                    }else{?>

                        <a href="index.php?r=pmt/defect/defect-view&id=<?=$_GET['id']?>&starttime=true" class="btn btn-sm  btn-success <?=$_COOKIE['defect_start_time']?'hideBtn':''?>"><i class="glyphicon glyphicon-time"></i> <?= Yii::t('app', 'Start Timer')?></a>

                    <?php }
					 }
					?>

                   

                    <?php

    

                    //ActiveForm::end ();

                    echo "</form>";

    ?>

    </div>
				 </div>

</div>





<?php

	//$entity_user=$model->assigned_user_id;

	$email=DefectController::getUserEmail($model->assigned_user_id);

	include_once(__DIR__ .'/../../../liveobjects/views/file/attachment-module/attachmentae.php');

	include_once(__DIR__ .'/../../../liveobjects/views/note/notes-module/noteae.php');

?>



<?php

$_SESSION['pid']=$model->project_id;

	include_once('sub-defect.php');

	include_once('defect_timingae.php');

	include_once('defect_time_noteae.php');

?>


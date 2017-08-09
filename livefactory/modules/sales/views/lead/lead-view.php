<?php

use livefactory\modules\sales\controllers\LeadController;

use livefactory\models\search\CommonModel;

use yii\helpers\Html;

use yii\helpers\ArrayHelper;

use livefactory\models\FileModel;

use kartik\widgets\ActiveForm;



use dosamigos\ckeditor\CKEditor;

use kartik\builder\Form;

use livefactory\models\search\Lead as LeadSearch;

/**

 * @var yii\web\View $this

 * @var common\models\Lead $model

 */





$this->title = Yii::t('app', 'Update Lead') . '- ' . $model->lead_id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leads'), 'url' => ['index']];

//$this->params['breadcrumbs'][] = ['label' => $model->lead_id, 'url' => ['view', 'id' => $model->id]];

$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

//$baseUrl="http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";

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

	if('<?=!empty($_GET['time_entry_id'])?$_GET['note_id']:''?>' !=''){

		$('.lead_timing').modal('show');

	}

	//Sub-Lead Script

	$(document).on('click','.leadScript',function(){

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

	 $('.sublead_insert').click(function(event){

		 Remove_Error($('.expected_end_datetime'));

		 Remove_Error($('.expected_start_datetime'));

		if($('.expected_start_datetime').val()==''){

			 Add_Error($('.expected_start_datetime'),'<?=Yii::t ( 'app', 'This Field is Required!')?>');

			 event.preventDefault();

		}else{

			Remove_Error($('.expected_start_datetime'));

		}

		if($('.expected_end_datetime').val()==''){

			 Add_Error($('.expected_end_datetime'),'<?=Yii::t ( 'app', 'This Field is Required!')?>');

			 event.preventDefault();

		}else{

			Remove_Error($('.expected_end_datetime'));

		}

	 })

	$('#lead-expected_start_datetime-disp').val($('#lead-expected_start_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->expected_start_datetime))?>');

	$('#lead-expected_end_datetime-disp').val($('#lead-expected_end_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->expected_end_datetime))?>');

	$('#lead-actual_start_datetime-disp').val($('#lead-actual_start_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->actual_start_datetime))?>');

	$('#lead-actual_end_datetime-disp').val($('#lead-actual_end_datetime').val()=='0000-00-00 00:00:00'?'':'<?=date('D j M Y H:i:s',strtotime($model->actual_end_datetime))?>');

	

/*$('#lead-actual_end_datetime').change(function(){

	setTimeout(function(){

	if($('#lead-lead_status_id').val() ==2){

		var actual_start = $('#lead-actual_start_datetime').val();

		var actual_end = $('#lead-actual_end_datetime').val();

		var startTime = new Date(actual_start);

		var endTime = new Date(actual_end);

		//alert($('#lead-actual_end_datetime').val());

	//	alert(startTime>endTime);

		Remove_Error($('#lead-actual_end_datetime-disp'));

		if(startTime>endTime){

			 Add_Error($('#lead-actual_end_datetime-disp'),'Start Time Should be Less then Completion Time');

			 $('.update_lead').attr('disabled',true);

		}else{

			Remove_Error($('#lead-actual_end_datetime-disp'));

			  $('.update_lead').removeAttr('disabled');

		}

	}

	},1000)

})

$('#lead-lead_status_id').change(function(){

	if($('#lead-lead_status_id').val() ==2){

		if('<?=!empty($_COOKIE['inserted_notes'.$model->id])?$_COOKIE['inserted_notes'.$model->id]:''?>' != '1'){

			$('.add-notes-modal').modal('show');

		}

	}

})

$('.update_lead').click(function(event){

	if($('#lead-lead_status_id').val() ==2){

			if('<?=!empty($_COOKIE['inserted_notes'.$model->id])?$_COOKIE['inserted_notes'.$model->id]:''?>' != '1'){

				alert('Please Add Notes!');

				$('.add-notes-modal').modal('show');

				event.preventDefault();

			}else{

				

				error='';

				Remove_Error($('#lead-actual_start_datetime-disp'));

				Remove_Error($('#lead-actual_end_datetime-disp'));

				

				var actual_start = $('#lead-actual_start_datetime').val();

				var actual_end = $('#lead-actual_end_datetime').val();

				var startTime = new Date(actual_start);

				var endTime = new Date(actual_end);

				 //alert($('#lead-actual_end_datetime').val());

	            // alert(startTime>endTime);

				if(startTime>endTime){

					 error+=Add_Error($('#lead-actual_end_datetime-disp'),'Start Time Should be Less then Completion Time');

				}else{

					Remove_Error($('#lead-actual_end_datetime-disp'));

				}

				if($('#lead-actual_start_datetime-disp').val() ==''){

					error+=Add_Error($('#lead-actual_start_datetime-disp'),'This field Required!');

				}else{

					Remove_Error($('#lead-actual_start_datetime-disp'));

				}

				if($('#lead-actual_start_datetime-disp').val() ==''){

					error+=Add_Error($('#lead-actual_end_datetime-disp'),'This field Required!');

				}else{

					Remove_Error($('#lead-actual_end_datetime-disp'));

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

	})*/

	$('#lead-customer_id').attr('disabled','disabled');

	$('.stopTime').click(function(){

		$('.leadnotes').modal('show');

	})

});

if('<?=isset($_COOKIE['leadStartedId'])?$_COOKIE['leadStartedId']:''?>' !=''){

	if('<?=isset($_COOKIE['leadStartedId'])?$_COOKIE['leadStartedId']:''?>' == <?= $model->id ?>){

		setInterval(function(){

		$.post('<?=str_replace('index.php','',$_SESSION['base_url'])?>ajax_clock_lead.php',function(result){

			var alink ='<i class="glyphicon glyphicon-time"></i> Stop Timer '+result;

				$(".stopTime").html(alink);	

			})

		},1000)

	}

}

	

</script>
<div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5><?=Yii::t ( 'app', 'Lead View')?> - <small class="m-l-sm"><?= $model->lead_id ?></small></h5>

                        <div class="ibox-tools">
							<a href="index.php?r=customer/customer/customer-view&id=<?=$model->customer_id?>" class="btn btn-xs btn-info" style="color:#fff;"><span class="glyphicon glyphicon-new-window"></span> <?= Yii::t('app', 'View Customer')?></a>
						    <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

                    </div>

                    <div class="ibox-content">

    <div class="lead-update">



		<?= $this->render('_form', [

            'model' => $model,

        ]) ?>

    

    </div>

    <div class="tabbable">

        <ul class="nav nav-tabs">

        <li class="active"><a href="#desc" role="tab" data-toggle="tab"><?=Yii::t ( 'app', 'Lead Description')?></a></li>

        <li><a href="#attachments" role="tab" data-toggle="tab"><?=Yii::t ( 'app', 'Attachments')?>	

           

            <span class="badge"> <?= FileModel::getAttachmentCount('lead',$model->id)?></span>

        </a></li>

        <li><a href="#notes" role="tab" data-toggle="tab"><?=Yii::t ( 'app', 'Notes')?></a></li>

        <li><a href="#subleadtab" role="tab" data-toggle="tab"><?=Yii::t ( 'app', 'Sub Lead')?>

        	<span class="badge"><?= LeadSearch::getSubLeadCount($model->id)?></span>

        	 

        </a></li>

        <li><a href="#timesheet" role="tab" data-toggle="tab"><?=Yii::t ( 'app', 'Timesheet')?></a></li>

        <li><a href="#assign_history" role="tab" data-toggle="tab"><?=Yii::t ( 'app', 'Assignment History')?></a></li>

        <!--<li><a href="#history" role="tab" data-toggle="tab">History</a></li>-->

        <li><a href="#history" role="tab" data-toggle="tab"><?=Yii::t ( 'app', 'Activity')?></a></li>

        </ul>

    

    <div class="tab-content">

    <div class="tab-pane  active" id="desc"> 

    <br/>

    <?php

    echo '<div class="row">

                    <div class="col-sm-12">

                        <div class="form-group">

                        <label class="control-label" for="lname">'.Yii::t ( 'app', 'Description').':

    

                        </label>

                        <div class="controls">

                          <textarea class="form-control input-sm ckeditor" name="Lead[lead_description]" id="lead_description" rows="8" style="width:100%">'.$model->lead_description.'</textarea>

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

                                $dataProviderAttach = $searchModelAttch->searchAttachments( Yii::$app->request->getQueryParams (), $model->id,'lead' );

                                

                                echo Yii::$app->controller->renderPartial("../../../liveobjects/views/file/attachment-module/attachments", [ 

                                        'dataProviderAttach' => $dataProviderAttach,

                                        'searchModelAttch' => $searchModelAttch,

                                        //'lead_id'=>$model->id

                                ] );

                                

                                ?>

    </div>

    <div class="tab-pane fade" id="notes"> 

    <br/>	

                 <?php

                                

                                $searchModelNotes = new CommonModel();

                                $dataProviderNotes = $searchModelNotes->searchNotes( Yii::$app->request->getQueryParams (), $model->id,'lead' );

                                

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

                                $dataProviderHistory = $searchModelHistory->searchHistory( Yii::$app->request->getQueryParams (), $model->id,'lead' );

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

                $dataProviderAssHis = $searchModelAssHis->searchAssignedHistory( Yii::$app->request->getQueryParams (), $model->id,'lead'  );

                

                echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/assigned_histories", [ 

                        'dataProviderAssHis' => $dataProviderAssHis,

                        'searchModelAssHis' => $searchModelAssHis 

                ] );

                

                ?>     

    </div>

    <div class="tab-pane fade" id="timesheet"> 

    <br/>			

            <?php

                                

              	$searchModelLeadTime = new LeadSearch();

                $dataProviderLeadTime = $searchModelLeadTime->searchLeadTime( Yii::$app->request->getQueryParams (), $model->id,'lead');

				

                echo Yii::$app->controller->renderPartial("lead_timing_tab", [ 

                        'dataProviderLeadTime' => $dataProviderLeadTime,

                        'searchModelLeadTime' => $searchModelLeadTime,

						'assigned_user_id'=>$model->assigned_user_id,

                ] );

                

                ?>      

    </div>

    <div class="tab-pane fade" id="subleadtab"> 

    <br/>			

            <?php

                                

                $searchModelLead = new LeadSearch();

                $dataProviderLead = $searchModelLead->searchSubLead( Yii::$app->request->getQueryParams (), $model->id );

                

                echo Yii::$app->controller->renderPartial("sub_lead_tab", [ 

                        'dataProviderLead' => $dataProviderLead,

                        'searchModelLead' => $searchModelLead 

                ] );

                

                ?>      

    </div>

    <div class="tab-pane fade" id="activity"> 

    <br/>			

            <?php

                                

                $searchModelActivity = new CommonModel();

                $dataProviderActivity = $searchModelActivity->searchActivity( Yii::$app->request->getQueryParams (), $model->id,'lead' );

                

                echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/activity_tab", [ 

                        'dataProviderActivity' => $dataProviderActivity,

                        'searchModelActivity' => $searchModelActivity 

                ] );

                

                ?>      

    </div>

    <input type="hidden" name="old_owner" value="<?=$model->assigned_user_id?>">

    <input type="hidden" name="old_lead_priority_id" value="<?=$model->lead_priority_id?>">

    <input type="hidden" name="old_lead_status_id" value="<?=$model->lead_status_id?>">

    </div>

    <?php

    echo Html::submitButton ( $model->isNewRecord ? Yii::t ( 'app','Create') : Yii::t ( 'app', 'Update'), [ 

    

                            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-sm  update_lead' 

    

                    ] );?> <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.add-notes-modal').modal('show');"><i class="glyphicon glyphicon-comment"></i> <?=Yii::t ( 'app', 'New Note')?></a>

                    <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.savepopup').modal('show');"><i class="glyphicon glyphicon-save"></i> <?=Yii::t ( 'app', 'New Attachment')?></a>

                    <a href="javascript:void(0)" class="btn btn-success btn-sm leadScript" onClick="$('.leadae').modal('show');"><i class="glyphicon glyphicon-tag"></i> <?=Yii::t ( 'app', 'Add Sublead')?></a>

                     

                     <?php

                    if(!empty($_COOKIE['lead_start_time'])){

                        if($_COOKIE['leadStartedId']==$_GET['id']){

                    ?>

                    <a href="javascript:void(0)" class="btn btn-sm   btn-danger <?=$_COOKIE['lead_start_time']?'':'hideBtn'?> stopTime"  data-toggle="modal"><i class="glyphicon glyphicon-time"></i> <?=Yii::t ( 'app', 'End Timer')?></a>

                    <?php 

                        }

                    }else{?>

                        <a href="index.php?r=sales/lead/lead-view&id=<?=$_GET['id']?>&starttime=true" class="btn btn-sm  btn-success <?=$_COOKIE['lead_start_time']?'hideBtn':''?>"><i class="glyphicon glyphicon-time"></i> <?=Yii::t ( 'app', 'Start Timer')?></a>

                    <?php }?>

                    

                    <?php

    

                    //ActiveForm::end ();

                    echo "</form>";

    ?>

    </div>

    </div>

</div>





<?php

	//$entity_user=$model->assigned_user_id;

	$email=LeadController::getUserEmail($model->assigned_user_id);

	include_once(__DIR__ .'/../../../liveobjects/views/file/attachment-module/attachmentae.php');

	include_once(__DIR__ .'/../../../liveobjects/views/note/notes-module/noteae.php');

?>



<?php

$_SESSION['customer_id']=$model->customer_id;

	include_once('sub-lead.php');

	include_once('lead_timingae.php');

	include_once('lead_time_noteae.php');

?>


<?php

use livefactory\models\search\CommonModel;
use livefactory\models\search\Customer;
use yii\helpers\Html;
use livefactory\models\FileModel;
use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;

use kartik\builder\Form;

use livefactory\models\Country;
use livefactory\models\State;
use livefactory\models\City;
use kartik\widgets\DepDrop;

use kartik\datecontrol\DateControl;

use livefactory\models\CustomerType;

/**
 * @var yii\web\View $this
 * @var common\models\Project $model
 */

$this->title = Yii::t('app', 'Update Client').' : ' . $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
///$this->params['breadcrumbs'][] = ['label' => $model->customer_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<script src="../include/jquery.js"></script>
<script src="../include//ckeditor/ckeditor.js"></script>
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
 function loadState(){
$('#state_id').load('<?=$baseUrl?>?r=liveobjects/address/ajax-load-states&country_id='+escape('<?=$addressModel->country_id?>')+'&state_id='+escape('<?=$addressModel->state_id?>'));
		
}
function loadCity(){
			$('#city_id').load('<?=$baseUrl?>?r=liveobjects/address/ajax-load-cities&state_id=<?=$addressModel->state_id?>&city_id=<?=$addressModel->city_id?>')	
}
   
$(document).ready(function(){
   // $('.tabbable').appendTo('#w0');
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
	if('<?=!empty($_GET['contact_edit'])?$_GET['contact_edit']:''?>' !=''){
		$('.contactae').modal('show');
	}
	if('<?=!empty($_GET['address_edit'])?$_GET['address_edit']:''?>' !=''){
		$('.addressae').modal('show');
		
		$('#sub_state_id').load('<?=$baseUrl?>?r=liveobjects/address/ajax-load-states&country_id='+escape('<?=$sub_address_model->country_id?>')+'&state_id='+escape('<?=$sub_address_model->state_id?>'));
		$('#sub_city_id').load('<?=$baseUrl?>?r=liveobjects/address/ajax-load-cities&state_id=<?=$sub_address_model->state_id?>&city_id=<?=$sub_address_model->city_id?>')
	}
	$('#country_id').change(function(){
    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-states&country_id='+$(this).val(),function(result){
					$('#state_id').html(result);
					$('#city_id').html('<option value=""> --Select--</option>');
				})
	})
	$('#state_id').change(function(){
    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-cities&state_id='+$(this).val(),function(result){
					$('#city_id').html(result);
				})
	})
	$('#sub_country_id').change(function(){
    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-states&country_id='+$(this).val(),function(result){
					$('#sub_state_id').html(result);
					$('#sub_city_id').html('<option value=""> --Select--</option>');
				})
	})
	$('#sub_state_id').change(function(){
    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-cities&state_id='+$(this).val(),function(result){
					$('#sub_city_id').html(result);
				})
	})
	//Auto Load
	loadState();
	loadCity();
	/*$('.customer_submit').click(function(event){
		var error='';
		$('#w0 [data-validation="required"]').each(function(index, element) {
			//alert($(this).attr('id'));
			Remove_Error($(this));
			if($(this).val() == ''){
				error+=Add_Error($(this),'This Field is Required!');
			}else{
					Remove_Error($(this));							
			}
			if(error !=''){
				event.preventDefault();
			}else{
				return true;
			}
		});
	});*/
	$('.add_address').click(function(event){
		var error='';
		$('#addressform [data-validation="required"]').each(function(index, element) {
			//alert($(this).attr('id'));
			Remove_Error($(this));
			if($(this).val() == ''){
				error+=Add_Error($(this),'<?=Yii::t ('app','This Field is Required!')?>');
			}else{
					Remove_Error($(this));							
			}
			if(error !=''){
				event.preventDefault();
			}else{
				return true;
			}
		});
	});
	$('.add_contact').click(function(event){
		var error='';
		$('#contactform [data-validation="required"]').each(function(index, element) {
			//alert($(this).attr('id'));
			Remove_Error($(this));
			if($(this).val() == ''){
				error+=Add_Error($(this),'<?=Yii::t ('app','This Field is Required!')?>');
			}else{
					if($(this).is("[email-validation]")){
						var e=$(this).val();
						var atpos=e.indexOf("@");
						var dotpos=e.lastIndexOf(".");
							if (atpos<1 || dotpos<atpos+2 || dotpos+2>=e.length)
							  {
								  error+=Add_Error($(this),'Email Address Not Valide !');
							  }else{
								Remove_Error($(this));
							}	
					}else{
						Remove_Error($(this));
					}						
			}
			if(error !=''){
				event.preventDefault();
			}else{
				return true;
			}
		});
	});
	$('[data-valid-num="required"]').keypress(function(key) {
		if((key.charCode > 7 && key.charCode < 45) || key.charCode > 57  ) return false;
});
$('.upload').click(function(){
	$('.inp').click();
})
});
</script>
 <?php $form = ActiveForm::begin ( [ 

						'type' => ActiveForm::TYPE_VERTICAL , 
  						'options'=>array('enctype' => 'multipart/form-data')

				] );?>
 <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5><?php echo Yii::t('app', 'Client'); ?> - <small class="m-l-sm"><?=$model->customer_name?></small></h5>

                        <div class="ibox-tools">

						    <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

                    </div>

                    <div class="ibox-content">
        	<div class="project-update">
        		<div class="row">
                	<div class="col-sm-9">
						<?=  Form::widget ( [ 
    
                            
    
                            'model' => $model,
    
                            'form' => $form,
    
                            'columns' => 4,
    
                            'attributes' => [ 
    
                                    
    
                                    'customer_name' => [ 
    
                                            'type' => Form::INPUT_TEXT,
    
                                            'options' => [ 
    
                                                    'placeholder' => 'Enter Clients Name...',
    
                                                    'maxlength' => 255 
    
                                            ],
    
                                            'columnOptions' => [ 
    
                                                    'colspan' => 3 
    
                                            ] 
    
                                    ]
                            ]
                        ]
    
                     );?>
                     <?=  Form::widget ( [ 
    
                            
    
                            'model' => $model,
    
                            'form' => $form,
    
                            'columns' => 2,
    
                            'attributes' => [ 
    
                                    
    
                                    'customer_type_id' => [ 
    
                                            'type' => Form::INPUT_DROPDOWN_LIST,
    
                                            'options' => [ 
    'prompt' => '--Customer Type--',
                                                    'placeholder' => 'Enter Client Type...' 
    
                                            ],
    
                                            'items' => ArrayHelper::map ( CustomerType::find ()->orderBy ( 'type' )->asArray ()->all (), 'id', 'label' )
    
                                    ]
                                ] 
                        ]
    
                     );?>
                     <?=  Form::widget ( [ 
    
                            
    
                            'model' => $model,
    
                            'form' => $form,
    
                            'columns' => 2,
    
                            'attributes' => [ 
    
                                    
    
                                    'email' => [ 
    
                                            'type' => Form::INPUT_TEXT,
    
                                            'options' => [ 
                                                    'placeholder' => 'Enter Client Type...' 
    
                                            ]
    
                                    ]
                                ] 
                        ]
    
                     );?>
                   	</div>
                    <div class="col-sm-3" style="overflow:hidden" align="center">
                    	<label>Image / Logo</label><br/>
                    	<?php
							if(file_exists('../customers/'.$model->id.'.png')){?>
                            	<img src="../customers/<?=$model->id?>.png" height="170" class="upload  img-responsive">								
							<?php }else{?>
								<img src="../customers/nophoto.jpg" height="170" class="upload  img-responsive">
							<?php }
						?>
                        <input type="file" name="customer_image" class="form-control  inp">
                    </div>
                </div>
        
        </div>
        	<div class="tabbable">
                <ul class="nav nav-tabs">
                <li class="active"><a href="#contacts" role="tab" data-toggle="tab"><?php echo Yii::t('app', 'Contacts'); ?></a></li>
                <li><a href="#addresses" role="tab" data-toggle="tab"><?php echo Yii::t('app', 'Addresses'); ?></a></li>
                <li><a href="#attachment" role="tab" data-toggle="tab"><?php echo Yii::t('app', 'Attachments'); ?>
                 <span class="badge"> <?= FileModel::getAttachmentCount('customer',$model->id)?></span>
                </a></li>
                <li><a href="#projects" role="tab" data-toggle="tab"><?php echo Yii::t('app', 'Claims'); ?></a></li>
                <li><a href="#notes" role="tab" data-toggle="tab"><?php echo Yii::t('app', 'Notes'); ?></a></li>
                <li><a href="#activity" role="tab" data-toggle="tab"><?php echo Yii::t('app', 'Activity'); ?></a></li>
                
                </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade" id="contact_detail"> 
                <br/>
                </div>
                <div class="tab-pane" id="address"> 
                <br/>
                         <!-- <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Address 1</label>
                                    <input type="text" name="address_1" data-validation="required" class="form-control" value="<?=$addressModel->address_1?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Address 2</label>
                                    <input type="text" name="address_2" class="form-control" value="<?=$addressModel->address_2?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">ZipCode:</label>
                                    <input type="text" name="zipcode" data-validation="required" class="form-control"  value="<?=$addressModel->zipcode?>">
                                </div>
                            </div>
                        </div>-->
                		<?php
				/*echo '<div class="row">
						<div class="col-sm-4">
							<div class="form-group required">
								<label class="control-label">Country</label>
						'.Html::dropDownList('country_id',$addressModel->country_id,
     ArrayHelper::map(Country::find()->orderBy('country')->asArray()->all(), 'id', 'country'), ['prompt' => '--Select--','class'=>'form-control','id'=>'country_id','data-validation'=>'required' ]  ).'</div></div>
	 					<div class="col-sm-4">
						<div class="form-group required">
								<label class="control-label">State</label>
						'.Html::dropDownList('state_id',$addressModel->state_id,
     ArrayHelper::map(State::find()->where('id=0')->orderBy('state')->asArray()->all(), 'id', 'state'), ['prompt' => '--Select--','class'=>'form-control','id'=>'state_id','data-validation'=>'required' ]  ).'</div></div>
	 				<div class="col-sm-4">
						<div class="form-group required">
								<label class="control-label">City</label>
						'.Html::dropDownList('city_id',$addressModel->city_id,
     ArrayHelper::map(City::find()->where('id=0')->orderBy('city')->asArray()->all(), 'id', 'city'), ['prompt' => '--Select--','class'=>'form-control','id'=>'city_id' ]  ).'</div></div></div>';*/
						?>
                </div>
                <div class="tab-pane fade" id="notes"> 
                <br/>	
                             <?php
                                            
                                            $searchModelNotes = new CommonModel();
                                            $dataProviderNotes = $searchModelNotes->searchNotes( Yii::$app->request->getQueryParams (), $model->id,'customer' );
                                            
                                            echo Yii::$app->controller->renderPartial("../../../liveobjects/views/note/notes-module/notes", [ 
                                                    'dataProviderNotes' => $dataProviderNotes,
                                                    'searchModelNotes' => $searchModelNotes
                                            ] );
                                            
                                            ?>
                </div>
                <div class="tab-pane fade" id="attachment"> 
                <br/>			
                          <?php
                                            
                                         $searchModelAttch = new CommonModel();
                                        $dataProviderAttach = $searchModelAttch->searchAttachments( Yii::$app->request->getQueryParams (), $model->id,'customer');
                                        
                                        echo Yii::$app->controller->renderPartial("../../../liveobjects/views/file/attachment-module/attachments", [ 
                                                'dataProviderAttach' => $dataProviderAttach,
                                                'searchModelAttch' => $searchModelAttch,
                                                'task_id'=>$model->id,
												'entity_type'=>'customer',
                                        ] );
                                            
                                            ?>
                </div>
                <div class="tab-pane fade" id="activity"> 
                <br/>			
                        <?php
                                            
                           $searchModelHistory = new CommonModel();
                                $dataProviderHistory = $searchModelHistory->searchHistory( Yii::$app->request->getQueryParams (), $model->id,'customer' );
                                echo Yii::$app->controller->renderPartial("../../../liveobjects/views/history/history-module/histories", [ 
                                        'dataProviderHistory' => $dataProviderHistory,
                                        'searchModelHistory' => $searchModelHistory 
                                ] );
                            
                            ?>      
                </div>
                <div class="tab-pane fade" id="projects"> 
                <br/>			
                        <?php
                                            
                            $projects = new Customer();
                            $dataProvider = $projects->searchProject( Yii::$app->request->getQueryParams (), $model->id);
                            
                            echo Yii::$app->controller->renderPartial("project_tab", [ 
                                    'dataProvider' => $dataProvider
                            ] );
                            
                            ?>      
                </div>
                <div class="tab-pane fade" id="addresses"> 
                <br/>			
                        <?php
                                            
                            $searchAddresses = new CommonModel();
                            $dataProviderAddresses = $searchAddresses->searchAddresses( Yii::$app->request->getQueryParams (), $model->id,'customer');
                            
                            echo Yii::$app->controller->renderPartial("../../../liveobjects/views/address/address-model/addresses", [ 
                                    'dataProviderAddresses' => $dataProviderAddresses
                            ] );
                            
                            ?>      
                </div>
                <div class="tab-pane   active" id="contacts"> 
                <br/>			
                        <?php
                                            
                            $searchContacts = new CommonModel();
                            $dataProviderContacts = $searchContacts->searchContacts( Yii::$app->request->getQueryParams (), $model->id,'customer');
                            
                            echo Yii::$app->controller->renderPartial("../../../liveobjects/views/contact/contact-model/contacts", [ 
                                    'dataProviderContacts' => $dataProviderContacts
                            ] );
                            
                            ?>      
                </div>
            </div>
          </div>
           <?php
            echo Html::submitButton ( $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [ 
            
                                    'class' => $model->isNewRecord ? 'btn btn-success customer_submit' : 'btn btn-primary btn-sm  customer_submit' 
            
                            ] );?> <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.add-notes-modal').modal('show');"><i class="glyphicon glyphicon-comment"></i> <?=Yii::t('app', 'New Note')?></a>
                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.savepopup').modal('show');"><i class="glyphicon glyphicon-save"></i> <?=Yii::t('app', 'New Attachment')?></a>
                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.addressae').modal('show');"><i class="glyphicon glyphicon-road"></i> <?=Yii::t('app', 'New Address')?></a>
                             <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.contactae').modal('show');"><i class="glyphicon glyphicon-phone"></i> <?=Yii::t('app', 'New Contact')?></a>
                             <a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$('.sendEmail').modal('show');"><i class="fa fa-envelope"></i> <?=Yii::t('app', 'Send Email')?></a>
                             
                            
                            
                          
    </div>
    
</div>  <?php
            
                            //ActiveForm::end ();
                            echo "</form>";
            ?>
<?php
	$email=$model->email;
	include_once(__DIR__ .'/../../../liveobjects/views/file/attachment-module/attachmentae.php');
	include_once(__DIR__ .'/../../../liveobjects/views/note/notes-module/noteae.php');
	include_once(__DIR__ .'/../../../liveobjects/views/address/address-model/addressae.php');
	include_once(__DIR__ .'/../../../liveobjects/views/contact/contact-model/contactae.php');
	include_once(__DIR__ .'/../../../liveobjects/views/email-template/email-model/send-email.php');
?>
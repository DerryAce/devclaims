<?php

use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use yii\helpers\ArrayHelper;


use livefactory\models\Country;
use livefactory\models\State;
use livefactory\models\City;


/**

 *

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var livefactory\models\search\Address $searchModel

 */



$this->title = Yii::t ( 'app', 'System Settings' );

$this->params ['breadcrumbs'] [] = $this->title;



?>
<script src="../include/jquery.js"></script>
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
	$('#country_id').change(function(){
    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-states&country_id='+$(this).val(),function(result){
					$('#state_id').html(result);
					$('#city_id').html('<option value=""> --Select City--</option>');
				})
	})
	$('#state_id').change(function(){
    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-cities&state_id='+$(this).val(),function(result){
					$('#city_id').html(result);
				})
	})
	//Auto Load
	loadState();
	loadCity();
	$('.company_submit').click(function(event){
		var error='';
		$('[data-validation="required"]').each(function(index, element) {
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
	});
});
</script>
<script type="text/javascript">
   
$(document).ready(function(){
	$('.COLLAPSE_MENU,.FIXED_SIDEBAR,.TOP_NAVBAR,.BOXED_LAYOUT,FIXED_FOOTER').click(function(){
		if($(this).attr('class')=='COLLAPSE_MENU'){
			if($(this).val() =='1'){
				$('body').addClass('mini-navbar');
			}else{
				$('body').removeClass('mini-navbar');
			}
		}
		if($(this).attr('class')=='FIXED_SIDEBAR'){
			if($(this).val() =='1'){
				$('body').addClass('fixed-sidebar');
				$('.sidemenu').css({'position': 'relative', 'overflow': 'hidden', 'width': 'auto', 'height': '100%'});
				$('.sidemenu').addClass('slimScrollDiv');
			}else{
				$('body').removeClass('fixed-sidebar');
				$('.sidemenu').removeAttr('style');
				$('.sidemenu').removeClass('slimScrollDiv');
				$('.sidemenu').addClass('sidebar-collapse');
			}
		}
		if($(this).attr('class')=='BOXED_LAYOUT'){
			if($(this).val() =='1'){
				$('body').addClass('boxed-layout');
				$('.navbar.white-bg').addClass('navbar-static-top');
				$('.navbar.white-bg').removeClass('navbar-fixed-top');
				$('body').removeClass('fixed-nav');
			}else{
				$('body').removeClass('boxed-layout');
			}
		}
		if($(this).attr('class')=='TOP_NAVBAR'){
			if($(this).val() =='1'){				
				$('body').addClass('fixed-nav');
				$('body').removeClass('boxed-layout');
				$('.navbar.white-bg').addClass('navbar-fixed-top');
			}else{
				$('body').removeClass('fixed-nav');
				$('.navbar.white-bg').addClass('navbar-static-top');
				$('.navbar.white-bg').removeClass('navbar-fixed-top');
			}
		} 
		if($(this).attr('class')=='FIXED_FOOTER'){
			if($(this).val() =='1'){
				$('.footer').addClass('fixed');
			}else{
				$('.footer').removeClass('fixed');
			}
		}
	})
	$('.theme_color').change(function(){
		if($(this).val()=='18'){
			$('body').addClass('skin-1');
		}else if($(this).val()=='19'){
			$('body').removeClass('skin-1');
			$('body').addClass('skin-3');
		}else{
			$('body').removeClass('skin-1');
			$('body').removeClass('skin-3');
		}
	})
	setTimeout(function(){
		$('#theme').addClass('fade');
		$('#company').addClass('fade');
	},1000);
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
	
})
function reloadPage(){
	document.location.href='index.php?r=liveobjects/setting'	
}
	if('<?=!empty($reload)?$reload:''?>'=='yes'){
		reloadPage()
	}
	
</script>

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

<div class="logo-index">
	<!--
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	-->
    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo Yii::t ( 'app', 'System Settings' ); ?> <small class="m-l-sm"><?php echo Yii::t ( 'app', 'Changes will be at application level' ); ?></small></h5>
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
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                        <li class="active">
                        	<a href="#general" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'General Settings' ); ?></a>
                        </li>
                        <li><a href="#theme" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'Theme Settings' ); ?></a></li>
                        <li><a href="#logo" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'Logo Settings' ); ?></a></li>
                        <li><a href="#company" role="tab" data-toggle="tab"><?php echo Yii::t ( 'app', 'Company Settings' ); ?></a></li>
                        </ul>
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="general"> 
                             <br/>
                             <div class="row">
                             <div class="col-sm-12">
                             <form method="post" class="form-horizontal" action="index.php?r=liveobjects/setting/update" enctype="multipart/form-data">
                                <?php Yii::$app->request->enableCsrfValidation = true; ?>
                                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                <div class="row">
                                	<div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo Yii::t ( 'app', 'Application Name' ); ?></label>
                                    <div class="col-sm-4">
                                    	<input type="text" class="form-control" required name="application_name" value="<?=Yii::$app->params['APPLICATION_NAME'] ?>">
                                    </div></div>
                                </div>
                                <div class="row">
                                	<div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo Yii::t ( 'app', 'System Email' ); ?></label>
                                    <div class="col-sm-4"><input type="text" class="form-control" required name="system_email" value="<?=Yii::$app->params['SYSTEM_EMAIL'] ?>"></div></div>
                                </div>
                                <div class="row">
                                	<div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo Yii::t ( 'app', 'System Chat' ); ?></label>
                                    <div class="col-sm-4">
                                    	<select class="form-control" name="chat">
                                        	<option value="0" <?=Yii::$app->params['CHAT']=='1'?'':'selected' ?>><?php echo Yii::t ( 'app', 'No' ); ?></option>
                                            <option value="1" <?=Yii::$app->params['CHAT']=='1'?'selected':'' ?>><?php echo Yii::t ( 'app', 'Yes' ); ?></option>
                                        </select>
                                        </div></div>
                                </div>
                                <div class="row">
                                	<div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo Yii::t ( 'app', 'System Language' ); ?></label>
                                    <div class="col-sm-4">
                                    	<select class="form-control" name="LOCALE">
                                        	<?php
												foreach($languages as $lang){
											?>
                                        	<option value="<?php echo $lang['locale']?>" <?=$_SESSION['LOCALE'] !=$lang['locale']?'':'selected' ?>><?php echo $lang['language']; ?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                   </div>
                                </div>
                                <div class="row">
                                	<div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo Yii::t ( 'app', 'Search Page View' ); ?></label>
                                    <div class="col-sm-4">
                                    	<select class="form-control" name="DEFAULT_SEARCH_PAGE_VIEW">
                                        	<option  <?=Yii::$app->params['DEFAULT_SEARCH_PAGE_VIEW'] =='List View'?'selected':'' ?>>List View</option>
                                            <option  <?=Yii::$app->params['DEFAULT_SEARCH_PAGE_VIEW'] =='Tile View'?'selected':'' ?>>Tile View</option>
                                        </select>
                                        </div>
                                   </div>
                                </div>
                                <div class="row">
                                	<div class="form-group">
                                    <label class="col-sm-2"></label>
                                    <div class="col-sm-4"><input type="submit" value="<?php echo Yii::t ( 'app', 'Update' ); ?>" class="btn btn-primary btn-block"></div></div>
                                </div>
                                        
                            </form>
                            </div></div>
                        </div>
                        <div class="tab-pane" id="theme"> 
                            <br/>
                            <form  action="" method="post" enctype="multipart/form-data" name="task_time" id="task_time">
              <?php Yii::$app->request->enableCsrfValidation = true; ?>
    <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
    			<?php 
				if($dataProvider != NULL){
				foreach($dataProvider as $row){
					if($row['config_item_value'] !='Default'){
					?>
                        <div class="row">
                                <input type="hidden" value="<?=$row['id']?>" name="ids[]">
                                	<div class="form-group">
                                        <div class="col-sm-2">
                                        <label><?=$row['config_item_value']?></label>
                                        </div>
                                        <div class="col-sm-8">
                                        : <?php echo Yii::t ( 'app', 'Yes' ); ?>:
                                        <input type="radio" class="<?=$row['config_item_name']?>" name="active<?=$row['id']?>" value="1" <?=$row['active']=='1'?'checked':''?>>
                                        <?php echo Yii::t ( 'app', 'No' ); ?>:
                                        <input type="radio" class="<?=$row['config_item_name']?>" name="active<?=$row['id']?>" value="0" <?=$row['active']=='1'?'':'checked'?>>
                                    </div>
                                     </div>
                                      
                                </div>
                                <hr/>
                                <?php }
                                }
						}	
                                 ?>
                                 <div class="row">
                                 
                                 <div class="form-group">
                                    <div class="col-sm-2">
                                        <label><?php echo Yii::t ( 'app', 'Theme Color' ); ?></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select name="color" class="theme_color" class="form-control">
                                            <option value="">--<?php echo Yii::t ( 'app', 'Select' ); ?>--</option>
                                            <?php 
											if($dataProviderColor != NULL){
											foreach($dataProviderColor as $row1){?>
                                                <option value="<?=$row1['id']?>" <?=$row1['active']?'selected':''?>><?=$row1['config_item_value']?></option>
                                            <?php }
											
											}?>
                                        </select>
                                    </div>
                                    </div>
                                 </div>
                            <br/><br/>
                            <?= Html::submitButton(Yii::t ( 'app', 'Save Theme' ), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                     </form>
                        </div>
                        <div class="tab-pane fade" id="logo"> 
                            <br/>	
                             <form method="post" enctype="multipart/form-data">
								<?php Yii::$app->request->enableCsrfValidation = true; ?>
                                <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                <div class="row">
                                    <div class="col-sm-8">
                                    	<div class="form-group">
                                        	<input type="file" class="form-control" name="logo">
                                        </div>
                                        <div class="form-group">
                                        	<input type="submit" value="<?php echo Yii::t ( 'app', 'Upload Logo' ); ?>" class="btn btn-primary btn-block">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <img src="../logo/logo.png" class="img-responsive">
                                    </div>
                                </div>
                                </form>        
                        </div>
                        <div class="tab-pane" id="company"> 
                            <br/>			
                             <div class="company-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); 
	
	?>
    <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo Yii::t ( 'app', 'Company Detail' ); ?></h3>
                </div>
                <div class="panel-body">
    <?php
	echo Form::widget([

    'model' => $companyModel,
    'form' => $form,
    'columns' => 2,
    'attributes' => [

'company_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Name...', 'maxlength'=>255]], 

'company_email'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Email...', 'maxlength'=>255]], 

'company_phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Phone...', 'maxlength'=>255]], 

'company_mobile'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Mobile...', 'maxlength'=>255]], 

'company_fax'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Fax...', 'maxlength'=>255]], 

//'address_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Address ID...']], 

//'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

//'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

    ]


    ]);?>
    		</div>
         </div>
         <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo Yii::t ( 'app', 'Address Detail' ); ?></h3>
                </div>
                <div class="panel-body">
                <div class="row">
                	<div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label"><?php echo Yii::t ( 'app', 'Address 1' ); ?></label>
                        	<input type="text" name="address_1" value="<?=$addressModel->address_1?>" data-validation="required" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label"><?php echo Yii::t ( 'app', 'Address 2' ); ?></label>
                        	<input type="text" name="address_2" value="<?=$addressModel->address_2?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label"><?php echo Yii::t ( 'app', 'Zipcode' ); ?></label>
                        	<input type="text" name="zipcode" data-validation="required" value="<?=$addressModel->zipcode?>" class="form-control">
                        </div>
                    </div>
                </div>
					<?php
                    echo '<div class="row">
                            <div class="col-sm-4">
                                <div class="form-group required">
                                    <label class="control-label">'.Yii::t ( 'app', 'Country' ).'</label>
                            '.Html::dropDownList('country_id',$addressModel->country_id,
         ArrayHelper::map(Country::find()->orderBy('country')->asArray()->all(), 'id', 'country'), ['prompt' => '--Select--','class'=>'form-control','id'=>'country_id','data-validation'=>'required' ]  ).'</div></div>
                            <div class="col-sm-4">
                            <div class="form-group required">
                                    <label class="control-label">'.Yii::t ( 'app', 'State' ).'</label>
                            '.Html::dropDownList('state_id',$addressModel->state_id,
         ArrayHelper::map(State::find()->where('id=0')->orderBy('state')->asArray()->all(), 'id', 'state'), ['prompt' => '--Select--','class'=>'form-control','id'=>'state_id','data-validation'=>'required' ]  ).'</div></div>
                        <div class="col-sm-4">
                            <div class="form-group required">
                                    <label class="control-label">'.Yii::t ( 'app', 'City' ).'</label>
                            '.Html::dropDownList('city_id',$addressModel->city_id,
         ArrayHelper::map(City::find()->where('id=0')->orderBy('city')->asArray()->all(), 'id', 'city'), ['prompt' => '--Select--','class'=>'form-control','id'=>'city_id' ]  ).'</div></div></div></div></div>';
        
        echo Html::submitButton($companyModel->isNewRecord ? Yii::t ( 'app', 'Create' ) : Yii::t ( 'app', 'Update' ), ['class' => $companyModel->isNewRecord ? 'btn btn-success company_submit' : 'btn btn-primary company_submit']);
        ActiveForm::end(); ?>
    
    </div>     
                        </div>
                    </div>
                    </div>
				</div>
            </div>
    

</div>

<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var livefactory\models\Company $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Company',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="../include/jquery.js"></script>
<script>
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
$(document).ready(function(e) {
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
<div class="company-create">
    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?= Html::encode($this->title) ?> <small class="m-l-sm">Enter Company Deatils &  Address Details</small></h5>
                        <div class="ibox-tools">
						    <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
							<!--
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
							-->
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div></div></div>

<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use livefactory\models\UserRole;
use livefactory\models\UserType;
use livefactory\models\Status;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<body class="gray-bg">
<div class="middle-box loginscreen  animated fadeInDown">

        <div>
            <div>
                <h1 class="logo-name"><?= Html::encode("Uib") ?></h1>
            </div>
            <h3>Welcome to the Uib CRM</h3>
            <p>Please fill out the following fields to login:</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'm-t']); ?>
				
				<!--
				<div class="form-group">
                    <input class="form-control" name="username" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>
				-->

	
                <?= $form->field($model, 'email')->textInput(array('placeholder' => '', 'value' => ''))->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(array('placeholder' => '', 'value' => ''))->label(false) ?>
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
               <br/>
                <p class="text-muted text-center">
                 <a href="index.php?r=site/forgot-password"><small>Forgot password?</small></a><br/>
                <small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="javascript:void(0)" onClick="$('.user-modal').modal('show');">Create an account</a>
		

            <?php ActiveForm::end(); 
			$hasError = count($user_model->errors);
			?>
            <p class="m-t"> <small>&copy; 2017 Uib CRM | For KPLC Incident Management.</small> </p>
        </div>
</div>
<style>

	.modal-dialog{width:80% !important;}

</style>
<script src="../include/jquery.js"></script>
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/style.css" rel="stylesheet">
<script src="js/bootstrap.min.js"></script>
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
    $('.userSubmit').click(function(event){
		var error='';
		$('[data-validation="required"]').each(function(index, element) {
			Remove_Error($(this));
			$(this).removeAttr('style').next('.error').remove();
			if($(this).val() == ''){
				error+=Add_Error($(this),'This Field is Required!');
			}else{
					Remove_Error($(this));							
			}
		});
		if(error==''){
			return;	
		}else{
			event.preventDefault();
		}
	})
	if(<?=$hasError?>){
		$('.user-modal').modal('show');
	}
	if('<?=$msg?>' !=''){
		$('.msg').modal('show');
		setTimeout(function(){
			$('.msg').modal('hide');
		},2000);
	}
});

</script>
<div class="modal fade user-modal">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">New User</h4>
				  </div>
					<div class="modal-body">
						<?php
				
				$form = ActiveForm::begin ( [ 
						'type' => ActiveForm::TYPE_VERTICAL ,
						'options'=>array('enctype' => 'multipart/form-data')
				] );?>
                    <?php
					
				echo Form::widget ( [ 
						
						'model' => $user_model,
						'form' => $form,
						'columns' => 2,
						'attributes' => [ 
								
								'first_name' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => 'Enter First Name...',
												'maxlength' => 255 ,
												'data-validation'=>'required'
										] 
								],
								
								'last_name' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => 'Enter Last Name...',
												'maxlength' => 255,
												'data-validation'=>'required' 
										] 
								],
								
								'username' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => 'Enter Username...',
												'maxlength' => 255 ,
												'data-validation'=>'required'
										] 
								],

								'email' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => 'Enter Email...',
												'maxlength' => 255 ,
												'data-validation'=>'required'
										] 
								],
								
								'password_hash'=>['type'=> Form::INPUT_PASSWORD, 'options'=>['placeholder'=>'Enter Password...', 'maxlength'=>255,
												'data-validation'=>'required']]
						] 
				] );
				echo '<input type="hidden" name="User[status]" value="0">
					  <input type="hidden" name="User[user_role_id]" value="2">
					  <input type="hidden" name="User[user_type_id]" value="1">
					  <input type="hidden" name="User[created_at]" value="'.strtotime(date('Y-m-d H:s:i')).'">';
				
				echo Html::submitButton ( $user_model->isNewRecord ? 'Create' : 'Update', [ 
						'class' => $user_model->isNewRecord ? 'btn btn-primary userSubmit' : 'btn btn-primary userSubmit' 
				] );
				ActiveForm::end ();
				?>
			</div>
           			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade msg">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Registration Successful!</h4>
				  </div>
					<div class="modal-body">
						<?php echo $msg?>
					</div>
            </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



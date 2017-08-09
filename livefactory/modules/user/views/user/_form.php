<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use livefactory\models\UserRole;
use livefactory\models\UserType;
use livefactory\models\Status;

/**
 *
 * @var yii\web\View $this
 * @var common\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

 <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5> <?php echo $this->title; if($_GET['id']){ ?> <span class="pull-right label <?=$model->status =='10'?'label-primary':'label-danger'?>"> <?=$model->status =='10'?'Active':'Inactive'?> </span><?php } ?></h5>
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



<div class="user-form">

    <?php
				
				$form = ActiveForm::begin ( [ 
						'type' => ActiveForm::TYPE_VERTICAL ,
						'options'=>array('enctype' => 'multipart/form-data')
				] );?>
                
               <div class="row">
               		<div class="col-sm-9">
                    <?php
				echo Form::widget ( [ 
						
						'model' => $model,
						'form' => $form,
						'columns' => 3,
						'attributes' => [ 
								
								'first_name' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => Yii::t('app', 'Enter First Name').'...',
												'maxlength' => 255 
										] 
								],
								
								'last_name' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => Yii::t('app', 'Enter Last Name').'...',
												'maxlength' => 255 
										] 
								],
								
								'username' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => 'Enter Username...',
												'maxlength' => 255 
										] 
								],
								
								// 'auth_key'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Auth Key...', 'maxlength'=>32]],
								
								// 'password_hash'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Hash...', 'maxlength'=>255]],
								
								'email' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => Yii::t('app', 'Enter Email').'...',
												'maxlength' => 255 
										] 
								],
								
								'user_type_id' => [ 
										'type' => Form::INPUT_DROPDOWN_LIST,
										'options' => [ 
												'placeholder' => 'Enter User Type...' ,
												'prompt' => '--'.Yii::t('app', 'Select Type').'--'
										],
										'items'=>ArrayHelper::map(UserType::find()->orderBy('type')->asArray()->all(), 'id', 'label')
								],
								
								'user_role_id' => [ 
										'type' => Form::INPUT_DROPDOWN_LIST,
										'options' => [ 
												'placeholder' => 'Enter User Role...',
												'prompt' => '--'.Yii::t('app', 'Select Role').'--'
										],
										'items'=>ArrayHelper::map(UserRole::find()->orderBy('role')->asArray()->all(), 'id', 'label'),
								]
								,
								
								// 'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']],
								
								// 'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']],
								
								// 'role'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Role...']],
								
								/*
								'status' => [ 
										'type' => Form::INPUT_DROPDOWN_LIST,
										'options' => [ 
												'placeholder' => 'Enter Status...' 
										],
										'items'=>ArrayHelper::map(Status::find()->orderBy('label')->asArray()->all(), 'id', 'label')
								] 
								*/
						] 
				] );
				echo Form::widget ( [ 
						
						'model' => $model,
						'form' => $form,
						'columns' => 1,
						'attributes' => [ 
								
								'about' => [ 
										'type' => Form::INPUT_TEXTAREA,
										'label' => Yii::t('app', 'About'),
										'options' => [ 
												'placeholder' => Yii::t('app', 'About').'...',
												'maxlength' => 255 
										] 
								]
						] 
				] );
				echo '</div>';
				if($_GET['id']){?>
                <div class="col-sm-3">
                            <label><?php echo Yii::t('app', 'Photo'); ?> 
                            <?php if(file_exists('../users/'.$model->id.'.png')){?>
                            <a href="index.php?r=user/user/update&id=<?=$model->id?>&edit=t&img_del=yes" class="btn btn-danger btn-xs" onClick="return confirm('Are you Sure!')"><?php echo Yii::t('app', 'Delete'); ?></a>
                            <?php } ?>
                            </label><br/>
                            <?php
                                if(file_exists('../users/'.$model->id.'.png')){?>
                                    <img src="../users/<?=$model->id?>.png" height="170" class="upload  img-responsive">								
                                <?php }else{?>
                                    <img src="../users/nophoto.jpg" height="170" class="upload  img-responsive">
                                <?php }
                            ?>
                            <input type="file" name="user_image" class="inp">
                            	<br/><br/>
                 </div>
				<?php }
				echo '</div>';
				// 'password_reset_token'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Reset Token...', 'maxlength'=>255]],
				
				
				echo Html::submitButton ( $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [ 
						'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' 
				] );
				//
				if($_GET['id'] and Yii::$app->user->identity->user_role_id =='1' and $model->user_role_id !='1'){?>
                <a href="index.php?r=user/user/update&id=<?=$model->id?>&edit=t&status=<?=$model->status !='10'?'yes':'no'?>" onClick="return confirm('Are you Sure')" class="btn <?=$model->status !='10'?'btn-primary':'btn-danger'?>"><?=$model->status !='10'?'Activate User':'Deactivate User'?></a>
                
                <?php } 
				if($_GET['id'] and Yii::$app->user->identity->user_role_id =='1'){?>
                <a href="index.php?r=user/user/update&id=<?=$model->id?>&edit=t&reset_password=true" onClick="return confirm('Are you Sure')" class="btn btn-success"><?php echo Yii::t('app', 'Reset Password'); ?></a>
                
                <?php } 
				ActiveForm::end ();
				?>

</div>

</div>
</div>
